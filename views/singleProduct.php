<!DOCTYPE html>

<?php
include "../config/session.php";
require_once "../config/connection.php";

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET["id"]);
?>

<html>

<head>
    <title>Single product View</title>
    <link rel="stylesheet" href="../assests/css/singleProduct.css">
</head>

<body>
    <?php
    $sql = "SELECT
            product.*,
            category.c_name AS category_name,
            product_image.path,
            user.username AS seller_name
        FROM product
        LEFT JOIN category
            ON product.category = category.c_id
        LEFT JOIN product_image
            ON product.p_id = product_image.product
        LEFT JOIN user
            ON product.seller_id = user.user_id
        WHERE product.p_id = $id";

    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "Product not found.";
        exit;
    }

    $row = $result->fetch_assoc();

    $image = !empty($row["path"])
        ? $row["path"]
        : "../assets/images/default-product.jpg";
    ?>
    <div class="product-container">

        <div class="image-section">
            <img src="<?php echo $image; ?>">
        </div>

        <div class="details-section">

            <h1><?php echo $row["p_name"]; ?></h1>

            <h2>Rs. <?php echo number_format($row["price"], 2); ?></h2>

            <p>
                <strong>Category :</strong>
                <?php echo $row["category_name"]; ?>
            </p>

            <p>
                <strong>Seller :</strong>
                <?php echo $row["seller_name"]; ?>
            </p>
            <p>
                <strong>Quantity :</strong>
                <?php echo $row["qty"]; ?>
            </p>

            <p>
                description not available for this moment.
            </p>

            <div class="buttons">

                <button class="cart-btn" onclick="cart()">
                    Add to Cart
                </button>

                <button class="buy-btn"
                    onclick="openBuyModal(<?php echo $row['p_id']; ?>, <?php echo $row['qty']; ?>)">
                    Buy Now
                </button>

            </div>

        </div>

    </div>
    <div id="buyModal" class="modal">

        <div class="modal-content">

            <span class="close" onclick="closeBuyModal()">&times;</span>

            <h2><?php echo $row["p_name"]?></h2>
            <h3>You are close to buy this product...</h3>

            <p>Available quantity:
                <span id="availableQty"></span>
            </p>

            <input type="number"
                id="buyQty"
                min="1"
                placeholder="Enter quantity">

            <button onclick="proceedCheckout()">
                Continue
            </button>

        </div>

    </div>
    <script src="../assests/js/singleProduct.js"></script>
</body>

</html>