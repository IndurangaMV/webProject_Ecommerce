<?php
include "../config/session.php";
require_once "../config/connection.php";

// 1. Double check that the user is actually logged in and form was submitted via POST
if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/login.php");
    exit();
}

$current_user = $_SESSION['user'];

// 2. Sanitize and grab incoming form data inputs from the $_POST superglobal
$firstname    = $_POST['firstname'];
$lastname     = $_POST['lastname'];
$displayname  = $_POST['displayname']; // Maps to the 'username' field in your table
$email        = $_POST['email'];
$password_val = $_POST['current_password'];

// 3. Write your MySQLi UPDATE statement string
// We match the target row using the logged-in session user identifier
$query = "UPDATE user SET firstname = ?, lastname = ?, username = ?, email = ?, password = ? WHERE username = ?";

$stmt = $conn->prepare($query);

if ($stmt) {
    // "ssssss" means all 6 variables are bound strings in the exact positional sequence
    $stmt->bind_param("ssssss", $firstname, $lastname, $displayname, $email, $password_val, $current_user);
    
    if ($stmt->execute()) {
        // 4. Update your session user key if they decided to edit their username
        $_SESSION['user'] = $displayname;
        
        // 5. Output the JavaScript alert window upon success and bounce back
        echo "<script>
                alert('Data stored successfully!');
                window.location.href = '../views/userProfile.php';
              </script>";
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Statement preparation failed: " . $conn->error;
}
?>