<?php
include "../config/session.php";
require_once "connection.php";

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";

if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["user"] = $row["username"];
        $_SESSION["user_type"] = $row["user_type"];
        if ($_SESSION["user_type"] == 3) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'redirect' => '../views/index.php']);
                exit;
            }
            header("Location: ../views/index.php");
            exit;
        } else if ($_SESSION["user_type"] == 1 || $_SESSION["user_type"] == 2) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'redirect' => '../views/dashboard.php']);
                exit;
            }
            header("Location: ../views/dashboard.php");
            exit;
        } else {
            echo "Invalid Login";
            exit;
        }
    } else {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
            exit;
        }
        header("Location: ../views/login.php?showModel=3");
        exit;
    }
}
