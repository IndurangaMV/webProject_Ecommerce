<?php
include "../config/session.php";

// CHECK LOGIN
if(!isset($_SESSION["user"])){
    header("Location: ../views/login.php");
    exit;
}else{
    ?>
    <h1>Welcome <?php echo $_SESSION["user"]; ?></h1><br>
    <?php
    if($_SESSION["user_type"]==1){
        ?>
        <a href="../views/customerManagement.php">Customer Management</a><br>
        <a href="../views/sellerManagement.php">Seller Management</a><br>
        <a href="../views/productManagement.php">Product Management</a><br>
        <a href="../views/userManagement.php">Admin Dashboard</a>
        <?php
    }else if($_SESSION["user_type"]==2){
        ?>
        <a href="../views/addNewProduct.php">Add new Product</a><br>
        <a href="../views/sellerProfile.php">Seller Profile</a>
        <?php
    }else if($_SESSION["user_type"]==3){
        ?>
        <a href="../views/userProfile.php">User Profile</a><br>
        <a href="../views/home.php">Home</a>
        <?php
    }else{
        echo "Invalid User Type";
    }
    ?>
    <br><a href="../config/logout.php">Logout</a><?php
}
?>


