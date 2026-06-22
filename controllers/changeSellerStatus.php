<?php

include "../config/connection.php";
include "../config/session.php";


// ADMIN CHECK
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
    header("Location: ../views/login.php");
    exit;
}


// GET DATA
$id = $_GET['id'];
$action = $_GET['action'];


// DEFAULT STATUS
$status = null;


// MAP ACTIONS → STATUS
if ($action == "approve" || $action == "activate") {
    $status = "ACTIVE";
}
elseif ($action == "reject") {
    $status = "REJECTED";
}
elseif ($action == "suspend") {
    $status = "SUSPENDED";
}


// UPDATE STATUS
if ($status != null) {

    $sql = "
    UPDATE user
    SET status='$status'
    WHERE user_id='$id'
    AND user_type=2
    ";

    $conn->query($sql);
}


// BACK TO PAGE
header("Location: ../views/sellerManagement.php");
exit;

?>