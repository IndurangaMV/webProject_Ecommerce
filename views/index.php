<?php
include "../config/session.php";
require_once "../config/connection.php";
// CHECK LOGIN

?>
<!DOCTYPE html>
<html>

<head>
    <title>Home - Gamma Electronics</title>
    <link rel="stylesheet" href="../assests/css/home.css">
</head>

<body>
    <?php include 'partials/header.php'; ?>
    <div class="header">
        <div class="title-block">
            <div class="logo-block">
                <img src="../assests/images/logo.webp" style="width: 200px;height:80px" alt="">
            </div>
            <div class="name-block">
                <h1>Gamma Electronics</h1>
                <!-- <h7 style="margin-top: 50px;margin-left: 10px ;border-left: 2px solid;">&nbsp;meet the future of technology</h7> -->
            </div>
        </div>
        <div class="nav-bar">
            <div class="nav-left">
                <span class="breadcumb">Home</span>
                <span class="breadcumb">Contact</span>
                <span class="breadcumb">Products</span>
            </div>
            <div class="nav-right">
                <?php
                if (!isset($_SESSION["user"])) {
                ?>
                    <a style="text-decoration: none;color:white" href="../views/login.php" class="profile-tab breadcumb">Sign In</a>
                <?php
                } else {
                ?>
                    <a style="text-decoration: none;color:white" href="../config/logout.php" class="profile-tab breadcumb">Sign Out</a>
                    <span class="profile-tab breadcumb">Profile</span>
                    <span class="profile-tab breadcumb" style="padding: 5px;"><img class="p-img" src="../assests/images/OIP.webp" alt=""></span>

                <?php
                }
                ?>
            </div>

        </div>
        <hr>
    </div>
    <h1>Gamma Electronics</h1>
    <?php
    $sql = "SELECT * FROM category";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cat_id = $row["c_id"];
            ?>
            <h3><?php echo $row["c_name"]; ?></h3><hr>
            <?php
            $sql2 = "SELECT * FROM product WHERE category=$cat_id";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
    ?>
                    <div class="product-card">
                        <h4><?php echo $row2["p_name"]; ?></h4>
                    </div>
            <?php
                }
            }
            ?>
          
    <?php
        }
    }
    include 'partials/footer.php';
    ?>


</body>

</html>