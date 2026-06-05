<?php
include "../config/session.php";
include "../config/connection.php";

if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit;
}

$username = $_SESSION["user"];
$stmt = $conn->prepare("SELECT u.user_id, u.username, u.email, u.contact_no, COALESCE(g.gender,'N/A') AS gender, COALESCE(u.status,'N/A') AS status, COALESCE(ut.type,'Unknown') AS user_type_label
                        FROM user u
                        LEFT JOIN gender g ON u.gender = g.gender_id
                        LEFT JOIN user_type ut ON u.user_type = ut.type_id
                        WHERE u.username = ?");
$user = null;
if ($stmt) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $user = $result->fetch_assoc();
    }
}

if (!$user) {
    echo "User profile not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<div class="container">
    <h1><?php echo htmlspecialchars($user['user_type_label']); ?> Profile</h1>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Contact:</strong> <?php echo htmlspecialchars($user['contact_no']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($user['status']); ?></p>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
