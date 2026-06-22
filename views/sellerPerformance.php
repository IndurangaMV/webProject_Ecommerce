<?php

include "../config/session.php";
include "../config/connection.php";


// ADMIN CHECK
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
    header("Location: ../views/login.php");
    exit;
}


// GET SELLER ID
$seller_id = $_GET['id'] ?? 0;

if ($seller_id <= 0) {
    header("Location: sellerManagement.php");
    exit;
}


// GET SELLER NAME
$seller = $conn->query("SELECT username FROM user WHERE user_id=$seller_id")->fetch_assoc();
$sellerName = $seller['username'];



// STATISTICS

$stats = $conn->query("
SELECT 
    COUNT(*) AS total_products,
    SUM(price) AS total_value,
    AVG(price) AS avg_price
FROM product
WHERE seller_id=$seller_id
")->fetch_assoc();



// PRODUCT LIST

$products = $conn->query("
SELECT p.p_id, p.p_name, c.c_name, p.price
FROM product p
LEFT JOIN category c ON p.category = c.c_id
WHERE p.seller_id=$seller_id
ORDER BY p.price DESC
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Performance</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>

<body>

<div class="container">

    <h2>Performance - <?php echo $sellerName; ?></h2>

    <!-- STATS -->
    <div class="stats-container">

        <div class="stat-card">
            <h3>Products</h3>
            <p><?php echo $stats['total_products']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Total Value</h3>
            <p>LKR <?php echo $stats['total_value']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Average Price</h3>
            <p>LKR <?php echo $stats['avg_price']; ?></p>
        </div>

    </div>

    <!-- PRODUCT TABLE -->
    <table border="1">

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
        </tr>

        <?php while($row = $products->fetch_assoc()){ ?>

            <tr>
                <td><?php echo $row['p_id']; ?></td>
                <td><?php echo $row['p_name']; ?></td>
                <td><?php echo $row['c_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
            </tr>

        <?php } ?>

    </table>

    <br>
    <a href="sellerManagement.php">Back</a>

</div>

</body>
</html>