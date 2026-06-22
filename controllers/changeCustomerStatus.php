<?php


// DATABASE + SESSION

include "../config/connection.php";
include "../config/session.php";



// ONLY ADMIN CAN ACCESS
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
    header("Location: ../views/login.php");
    exit;
}



// GET DATA FROM URL

$id = $_GET['id'];
$action = $_GET['action'];



// CHECK VALID ID
if ($id <= 0) {
    header("Location: ../views/customerManagement.php");
    exit;
}



// ACTIVATE CUSTOMER

if ($action == "activate") {

    $sql = "
    UPDATE user
    SET status='ACTIVE'
    WHERE user_id='$id' AND user_type=3
    ";

    $conn->query($sql);
}



// DEACTIVATE CUSTOMER
elseif ($action == "deactivate") {

    $sql = "
    UPDATE user
    SET status='INACTIVE'
    WHERE user_id='$id' AND user_type=3
    ";

    $conn->query($sql);
}



// DELETE CUSTOMER
elseif ($action == "delete") {

    $sql = "
    DELETE FROM user
    WHERE user_id='$id' AND user_type=3
    ";

    $conn->query($sql);
}


// GO BACK TO PAGE

header("Location: ../views/customerManagement.php");
exit;

?>