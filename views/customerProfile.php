<?php
include "../config/session.php";
include "../config/connection.php";

if (!isset($_SESSION["user"]) || $_SESSION["user_type"] != 1) {
    header("Location: ../views/login.php");
    exit;
}

$customerId = intval($_GET['id'] ?? 0);
if ($customerId <= 0) {
    header("Location: ../views/customerManagement.php");
    exit;
}

$stmt = $conn->prepare("SELECT u.user_id, u.username, u.email, u.contact_no, COALESCE(g.gender,'N/A') AS gender, COALESCE(u.status,'N/A') AS status
                        FROM user u
                        LEFT JOIN gender g ON u.gender = g.gender_id
                        WHERE u.user_id = ? AND u.user_type = 3");
$customer = null;
if ($stmt) {
    $stmt->bind_param('i', $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $customer = $result->fetch_assoc();
    }
}

if (!$customer) {
    echo "Customer not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Profile</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<div class="container">
    <h1>Customer Profile</h1>
    <p><strong>ID:</strong> <?php echo htmlspecialchars($customer['user_id']); ?></p>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($customer['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
    <p><strong>Contact:</strong> <?php echo htmlspecialchars($customer['contact_no']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($customer['gender']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($customer['status']); ?></p>

    <br>
    <a href="customerManagement.php">Back to Customer Management</a>
</div>
</body>
</html>
