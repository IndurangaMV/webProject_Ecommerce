<?php
require_once "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];
$gender = $_POST["gender"];
$province = $_POST["province"];
$district = $_POST["district"];
$postalCode = $_POST["postalCode"];
$address = $_POST["address"];
$email = $_POST["email"];
$confirmPassword = $_POST["confirmPassword"];
$contact = $_POST["contact"];
if ($password != $confirmPassword) {
    header("Location: ../views/login.php?showModel=5");
    exit;
} else {
    $checkMailQuery = "SELECT * FROM user WHERE email='$email'";
    if ($conn->query($checkMailQuery)->num_rows > 0) {
        header("Location: ../views/login.php?showModel=6");
        exit;
    } else {
        $sql = "INSERT INTO `user` (`username`, `password`, `email`, `contact_no`, `gender`, `user_type`,`district`,`address`,`zip_code`,`status`,`approval`) 
        VALUES ('$username', '$password', '$email', '$contact', '$gender',3, '$district','$address', '$postalCode','ACTIVE','1')";
        if ($conn->query($sql) === TRUE) {
            header("Location: ../views/login.php?showModel=4");
            exit;
        } else {
            header("Location: ../views/login.php?showModel=7,error=" . urlencode("Error: " . $sql . "<br>" . $conn->error));
        }
    }
}

