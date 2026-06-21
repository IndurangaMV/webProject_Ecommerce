<?php
include "../config/session.php";
require_once "../config/connection.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security verification check
if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/login.php");
    exit();
}

// Capture incoming form variables cleanly
$street_address = trim($_POST['street_address'] ?? '');
$district_id    = isset($_POST['district']) ? (int)$_POST['district'] : 0;
$current_user   = $_SESSION['user'];

// Ensure critical parameters aren't blank
if (!empty($street_address) && $district_id > 0) {
    
    // Core database update using correct relational parameters (String, Integer, String)
    $query = "UPDATE user SET address = ?, district = ? WHERE username = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sis", $street_address, $district_id, $current_user);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Address updated successfully!');
                    window.location.href = '../views/userProfile.php';
                  </script>";
            exit();
        }
        $stmt->close();
    }
}

// Fallback safety route redirect if field constraints drop validation flags
header("Location: ../views/userProfile.php");
exit();
?>