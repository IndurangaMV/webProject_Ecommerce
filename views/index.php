<?php
include "../config/session.php";
require_once "../config/connection.php";

$categorySql = "SELECT * FROM category ORDER BY c_name ASC";
$categoryResult = $conn->query($categorySql);

$productSql = "SELECT 
    product.*,
    category.c_name AS category_name,
    product_image.path
FROM product
LEFT JOIN product_image 
    ON product.p_id = product_image.product
LEFT JOIN category 
    ON product.category = category.c_id
ORDER BY product.p_name ASC;";
$productResult = $conn->query($productSql);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home - Gamma Electronics</title>
    <link rel="stylesheet" href="../assests/css/home.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <div class="container">
        <aside class="leftbar">
            <h2>Filter products</h2>
            <form id="searchForm" onsubmit="SearchProducts(); return false;">
                <label for="searchText">Search</label>
                <input id="searchText" type="text" name="text" placeholder="Search products by name or keyword" />

                <label for="category">Category</label>
                <select id="category" name="category">
                    <option value="">All Categories</option>
                    <?php if ($categoryResult && $categoryResult->num_rows > 0) {
                        while ($row = $categoryResult->fetch_assoc()) {
                    ?>
                            <option value="<?php echo htmlspecialchars($row["c_id"]); ?>"><?php echo htmlspecialchars($row["c_name"]); ?></option>
                    <?php }
                    } ?>
                </select>

                <div class="filter-row">
                    <div>
                        <label for="min_price">Min price</label>
                        <input id="min_price" type="number" name="min_price" min="0" step="1" placeholder="Minimum" />
                    </div>
                    <div>
                        <label for="max_price">Max price</label>
                        <input id="max_price" type="number" name="max_price" min="0" step="1" placeholder="Maximum" />
                    </div>
                </div>

                <label>Sort by price</label>
                <div class="sort-options">
                    <label><input id="lh" type="radio" name="sort" value="asc" checked> Low to High</label>
                    <label><input id="hl" type="radio" name="sort" value="desc"> High to Low</label>
                </div>

                <button type="submit">Search</button>
                <button type="button" class="secondary" onclick="clearFilters()">Reset</button>
            </form>
        </aside>
        <main class="rightbar">
            <div id="product-container">
                <div class="product-grid" id="product-grid">

                    <?php
                    if ($productResult && $productResult->num_rows > 0) {
                        while ($row = $productResult->fetch_assoc()) {
                    ?>
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="<?php echo $row["path"] ?>" alt="Product image" />
                                </div>
                                <div class="product-details">
                                    <h4 class="product-title"><?php echo htmlspecialchars($row["p_name"]); ?></h4>
                                    <p class="product-price">Rs. <?php echo number_format($row["price"], 2); ?></p>
                                    <p class="product-stock"><?php echo intval($row["qty"]) > 0 ? 'In stock' : 'Out of stock'; ?></p>
                                    <a href="singleProduct.php?id=<?php echo $row["p_id"]; ?>">
                                        <button class="btn-view">View Product</button>
                                    </a>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="no-results">No products available right now. Try adjusting the filters.</div>';
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <?php include 'partials/footer.php'; ?>
    <script src="../assests/js/home.js"></script>

</body>

</html>