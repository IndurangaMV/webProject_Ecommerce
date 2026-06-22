<?php
include "../config/session.php";
require_once "../config/connection.php";
// CHECK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit;
} else {
?>
    //put the code here for the dashboard page
<?php
}
?><?php
include "../config/session.php";

if (!isset($_SESSION["user"]) || $_SESSION["user_type"] != 1) {
    header("Location: ../views/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<div class="container">
    <h1>Admin User Management</h1>
    <div class="action-buttons">
        <a href="customerManagement.php" class="add-btn">Customer Management</a>
        <a href="sellerManagement.php" class="add-btn">Seller Management</a>
        <a href="productManagement.php" class="add-btn">Product Management</a>
    </div>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
