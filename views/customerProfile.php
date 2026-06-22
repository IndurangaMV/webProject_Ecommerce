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

$stmt = $conn->prepare("SELECT u.user_id, u.username,u.firstname,u.lastname, u.email, u.contact_no, COALESCE(g.gender,'N/A') AS gender, COALESCE(u.status,'N/A') AS status
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
include 'partials/header.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Profile</title>
    <link rel="stylesheet" href="../assests/css/customerProfile.css">
</head>
<body>

<div class="container">
    <div class="profile-box">

        <h2>Customer Profile</h2>

        <!-- Profile Info -->
       

        <div class="profile-row">
            <span class="label">Username</span>
            <span class="value"><?php echo htmlspecialchars($customer['username']); ?></span>
        </div>
         <div class="profile-row">
            <span class="label">Name</span>
            <span class="value"><?php echo htmlspecialchars($customer['firstname']." ".$customer["lastname"]); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">Email</span>
            <span class="value"><?php echo htmlspecialchars($customer['email']); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">Contact</span>
            <span class="value"><?php echo htmlspecialchars($customer['contact_no']); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">Gender</span>
            <span class="value"><?php echo htmlspecialchars($customer['gender']); ?></span>
        </div>

        <div class="profile-row">
            <span class="label">Status</span>
            <span class="value">
                <span class="profile-status <?php echo strtolower(htmlspecialchars($customer['status'])); ?>">
                    <?php echo htmlspecialchars($customer['status']); ?>
                </span>
            </span>
        </div>

        <!-- Back Button -->
        <div class="profile-actions">
            <a href="customerManagement.php" class="btn btn-dark">← Back to Customer Management</a>
        </div>

    </div>
</div>

<?php include 'partials/footer.php'; ?>

</body>
</html>