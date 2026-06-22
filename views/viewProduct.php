<?php
include "../config/session.php";
require_once "../config/connection.php";

if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("<h3 style='color:red'>Invalid Product ID</h3>");
}

// Fetch product details along with category, product image, and seller info
$sql = "SELECT 
            product.*, 
            category.c_name, 
            product_image.path AS image_path,
            seller.username AS seller_name,
            seller.email AS seller_email,
            seller.contact_no AS seller_contact,
            seller.address AS seller_address,
            seller.zip_code AS seller_zip,
            seller.status AS seller_status
        FROM product 
        LEFT JOIN category ON product.category = category.c_id 
        LEFT JOIN product_image ON product.p_id = product_image.product
        LEFT JOIN user AS seller ON product.seller_id = seller.user_id
        WHERE product.p_id = $id";

$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("<h3 style='color:red'>Product record could not be found</h3>");
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link rel="stylesheet" href="../assests/css/product.css">
    <link rel="stylesheet" href="../assests/css/viewProduct.css">
</head>
<body>

<div class="view-container">
    
    <div class="view-card">
        
        <!-- LEFT SIDE: Details (Specs & Seller Info) -->
        <div class="product-details">
            <h2>📋 Product Details</h2>
            <hr>

            <!-- Specifications -->
            <div class="info-section">
                <h3>Specifications</h3>
                
                <div class="data-group">
                    <span class="data-label">Name:</span> 
                    <span class="data-value"><?php echo htmlspecialchars($product['p_name']); ?></span>
                </div>

                <div class="data-group">
                    <span class="data-label">Price:</span> 
                    <span class="data-value price-tag">Rs. <?php echo number_format($product['price'], 2); ?></span>
                </div>

                <div class="data-group">
                    <span class="data-label">Stock:</span> 
                    <span class="data-value">
                        <?php 
                        $qty = isset($product['qty']) ? $product['qty'] : 0;
                        if (is_null($product['qty']) || $qty == 0) {
                            echo "<span class='badge badge-out'>Out of Stock</span>";
                        } else {
                            echo "<span class='badge badge-stock'>" . htmlspecialchars($qty) . " units available</span>";
                        }
                        ?>
                    </span>
                </div>

                <div class="data-group">
                    <span class="data-label">Category:</span> 
                    <span class="data-value"><?php echo htmlspecialchars($product['c_name'] ? $product['c_name'] : 'Uncategorized'); ?></span>
                </div>
            </div>

            <!-- Seller Info -->
            <div class="info-section">
                <h3>👤 Seller Profile</h3>
                
                <?php if (!empty($product['seller_name'])): ?>
                    <div class="data-group">
                        <span class="data-label">Name:</span> 
                        <span class="data-value"><?php echo htmlspecialchars($product['seller_name']); ?></span>
                    </div>

                    <div class="data-group">
                        <span class="data-label">Contact:</span> 
                        <span class="data-value"><?php echo htmlspecialchars($product['seller_contact']); ?></span>
                    </div>

                    <div class="data-group">
                        <span class="data-label">Zip Code:</span> 
                        <span class="data-value"><?php echo htmlspecialchars($product['seller_zip'] ? $product['seller_zip'] : 'N/A'); ?></span>
                    </div>

                    <div class="data-group">
                        <span class="data-label">Status:</span> 
                        <span class="data-value">
                            <?php 
                            $status = strtoupper($product['seller_status']);
                            if ($status === 'ACTIVE') {
                                echo "<span class='badge badge-active'>Active</span>";
                            } else {
                                echo "<span class='badge badge-inactive'>" . htmlspecialchars($status) . "</span>";
                            }
                            ?>
                        </span>
                    </div>
                <?php else: ?>
                    <!-- Clean info box instead of plain text -->
                    <div class="no-seller-alert">
                        <span class="alert-icon">ℹ️</span>
                        <div>
                            <h4>No Seller Profile Associated</h4>
                            <p>This item is currently listed directly by system admin.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <a href="productManagement.php" class="back-link">
                <button type="button" class="btn-return">Return to Dashboard</button>
            </a>
        </div>

        <!-- RIGHT SIDE: Constrained Product Image & Description -->
        <div class="product-visual">
            <div class="image-wrapper">
                <?php if (!empty($product['image_path'])): ?>
                    <img id="productImg" src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['p_name']); ?>">
                <?php else: ?>
                    <div class="no-image">📦 No Image</div>
                <?php endif; ?>
            </div>
            
            <div class="product-description">
                <h4>Description</h4>
                <p>
                    <?php 
                    echo isset($product['description']) && !empty($product['description']) 
                        ? htmlspecialchars($product['description']) 
                        : "Verified product. Contact seller for datasheet request or bulk orders."; 
                    ?>
                </p>
            </div>
        </div>

    </div>

</div>

<!-- Lightbox Modal -->
<div id="imageModal" class="modal">
    <span class="close-modal">&times;</span>
    <img class="modal-content" id="imgFull" alt="Enlarged view">
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const productImg = document.getElementById("productImg");
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("imgFull");
    const closeModal = document.querySelector(".close-modal");

    if (productImg && modal && modalImg) {
        productImg.addEventListener("click", function () {
            modal.style.display = "flex";
            modalImg.src = this.src;
        });

        closeModal.addEventListener("click", function () {
            modal.style.display = "none";
        });

        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    }
});
</script>

</body>
</html>