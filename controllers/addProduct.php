<?php
include '../config/session.php';
include '../config/connection.php';

$productName=$_POST['p_name'];
$category=$_POST['category'];
$qty=$_POST['qty'];
$price=$_POST['price'];
$s_id=$_SESSION["user_id"];

$sql="INSERT INTO product(p_name,price,category,seller_id,qty) VALUES ('$productName','$price','$category','$s_id','$qty')";
if($conn->query($sql)){
    echo "New product added successfully";
}else{
    echo "Error: " . $sql . $conn->error;
}
?>