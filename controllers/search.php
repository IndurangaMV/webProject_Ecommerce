<?php
require_once "../config/connection.php";
$query = "SELECT * FROM product JOIN category ON product.category = category.c_id WHERE 1=1";
if (!empty($_POST["min_price"])) {
    $query .= " AND price >= " . $_POST["min_price"];
}
if (!empty($_POST["max_price"])) {
    $query .= " AND price <= " . $_POST["max_price"];
}
if (!empty($_POST["text"])) {
    $query .= " AND p_name LIKE '%" . $_POST["text"] . "%'";
}
if (!empty($_POST["category"])) {
    $query .= " AND category = " . $_POST["category"];
}
if (!empty($_POST["sort"])) {
    $query .= " ORDER BY price " . $_POST["sort"];
}


$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cat_id = $row["category"];
?>
        <div class="product-card">
            <h4><?php echo $row["p_name"]; ?></h4>
            <span>Rs. <?php echo $row["price"]; ?></span><br>
            <span style="color:yellowgreen"><?php echo $row["qty"]; ?> items are available</span>
        </div>
        <hr>


<?php
    }
}
?>