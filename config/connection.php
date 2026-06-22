<?php

$servername="localhost:3307";
$username="root";
$password="";
$database="webProject";

$conn=new mysqli($servername,$username,$password,$database);

if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}

$userStatusCheck = $conn->query("SHOW COLUMNS FROM user LIKE 'status'");
if ($userStatusCheck && $userStatusCheck->num_rows === 0) {
    $conn->query("ALTER TABLE user ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'ACTIVE'");
}

$productSellerCheck = $conn->query("SHOW COLUMNS FROM product LIKE 'seller_id'");
if ($productSellerCheck && $productSellerCheck->num_rows === 0) {
    $conn->query("ALTER TABLE product ADD COLUMN seller_id INT(11) DEFAULT NULL");
}
?>