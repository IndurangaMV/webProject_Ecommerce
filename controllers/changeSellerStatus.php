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
  header("Location: ../views/sellerManagement.php");
  exit;
}

switch ($action) {
  case 'approve':
    $status = 'ACTIVE';
    break;
  case 'reject':
    $status = 'REJECTED';
    break;
  case 'suspend':
    $status = 'SUSPENDED';
    break;
  case 'activate':
    $status = 'ACTIVE';
    break;
  default:
    $status = null;
    break;
}

if ($status !== null) {
  $stmt = $conn->prepare("UPDATE user SET status = ? WHERE user_id = ? AND user_type = 2");
  if ($stmt) {
    $stmt->bind_param('si', $status, $id);
    $stmt->execute();
  }
}

header("Location: ../views/sellerManagement.php");
exit;
?>
