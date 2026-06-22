<?php
require_once "../config/connection.php";

$query = "SELECT product.*, category.c_name AS category_name FROM product LEFT JOIN category ON product.category = category.c_id WHERE 1=1";

if (!empty($_POST["min_price"]) && is_numeric($_POST["min_price"])) {
    $query .= " AND price >= " . intval($_POST["min_price"]);
}
if (!empty($_POST["max_price"]) && is_numeric($_POST["max_price"])) {
    $query .= " AND price <= " . intval($_POST["max_price"]);
}
if (!empty($_POST["text"])) {
    $searchText = $conn->real_escape_string(trim($_POST["text"]));
    $query .= " AND p_name LIKE '%$searchText%'";
}
if (!empty($_POST["category"]) && is_numeric($_POST["category"])) {
    $query .= " AND product.category = " . intval($_POST["category"]);
}

$sort = strtolower(trim($_POST["sort"] ?? "asc"));
if ($sort === "asc" || $sort === "desc") {
    $query .= " ORDER BY price " . $sort;
}

$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <div class="product-card">
            <div class="product-image">
                <img src="../assests/images/login/logo.png" alt="<?php echo htmlspecialchars($row['p_name']); ?>" />
            </div>
            <div class="product-details">
                <h4 class="product-title"><?php echo htmlspecialchars($row["p_name"]); ?></h4>
                <p class="product-price">Rs. <?php echo number_format($row["price"], 2); ?></p>
                <p class="product-stock"><?php echo intval($row["qty"]) > 0 ? 'In stock' : 'Out of stock'; ?></p>
                <button class="btn-view">View Product</button>
            </div>
        </div>
<?php
    }
} else {
    echo '<div class="no-results">No products found matching your filters.</div>';
}
?>