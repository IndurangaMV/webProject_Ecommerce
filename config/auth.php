<?php
include "../config/session.php";
require_once "connection.php";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";

if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["user"] = $row["username"];
        $_SESSION["user_type"] = $row["user_type"];
        if ($_SESSION["user_type"] == 3) {
            header("Location: ../views/index.php");
            exit;
        } else if ($_SESSION["user_type"] == 1 || $_SESSION["user_type"] == 2) {
            header("Location: ../views/dashboard.php");
            exit;
        } else {
            echo "Invalid Login";
        }
    }
}
