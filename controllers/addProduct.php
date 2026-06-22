<?php
include '../config/connection.php';

$productName=$_POST['p_name'];
$category=$_POST['category'];
$qty=$_POST['qty'];
$price=$_POST['price'];

$sql="INSERT INTO product(p_name,price,category,qty) VALUES ('$productName','$price','$category','$qty')";
if($conn->query($sql)){
    echo "New product added successfully";
}else{
    echo "Error: " . $sql . $conn->error;
}
?>