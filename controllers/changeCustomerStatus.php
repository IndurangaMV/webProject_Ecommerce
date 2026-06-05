<?php
// Connect to database and start session
include "../config/connection.php";
include "../config/session.php";

if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
  header("Location: ../views/login.php");
  exit;
}

$id = intval($_GET['id'] ?? 0);
$action = $_GET['action'] ?? '';

if ($id <= 0) {
  header("Location: ../views/customerManagement.php");
  exit;
}

switch ($action) {
  case 'activate':
    $status = 'ACTIVE';
    $stmt = $conn->prepare("UPDATE user SET status = ? WHERE user_id = ? AND user_type = 3");
    if ($stmt) {
      $stmt->bind_param('si', $status, $id);
      $stmt->execute();
    }
    break;
  case 'deactivate':
    $status = 'INACTIVE';
    $stmt = $conn->prepare("UPDATE user SET status = ? WHERE user_id = ? AND user_type = 3");
    if ($stmt) {
      $stmt->bind_param('si', $status, $id);
      $stmt->execute();
    }
    break;
  case 'delete':
    $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ? AND user_type = 3");
    if ($stmt) {
      $stmt->bind_param('i', $id);
      $stmt->execute();
    }
    break;
}

header("Location: ../views/customerManagement.php");
exit;
?>
