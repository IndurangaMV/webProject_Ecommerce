<?php
require_once "connection.php";

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$username = $_POST["username"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
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
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Your password does not match the re-entered password!', 'field' => 'confirmPassword']);
        exit;
    }
    header("Location: ../views/login.php?showModel=5");
    exit;
}

$checkMailQuery = "SELECT * FROM user WHERE email='$email'";
if ($conn->query($checkMailQuery)->num_rows > 0) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'The email you entered is already registered!', 'field' => 'email']);
        exit;
    }
    header("Location: ../views/login.php?showModel=6");
    exit;
}

$sql = "INSERT INTO `user` (`username`, `password`, `email`, `contact_no`, `gender`, `user_type`,`district`,`address`,`zip_code`,`first_name`,`last_name`,`status`,`approval`) 
VALUES ('$username', '$password', '$email', '$contact', '$gender',3, '$district','$address', '$postalCode','$firstName','$lastName','ACTIVE','1')";
if ($conn->query($sql) === TRUE) {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'Registration Successful! Please login with your credentials.']);
        exit;
    }
    header("Location: ../views/login.php?showModel=4");
    exit;
} else {
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Registration Failed! ' . $conn->error]);
        exit;
    }
    header("Location: ../views/login.php?showModel=7,error=" . urlencode("Error: " . $sql . "<br>" . $conn->error));
    exit;
}
