<?php
require '../config/connection.php';

header('Content-Type: application/json');

$username = trim($_GET['username'] ?? '');
if ($username === '') {
    echo json_encode(['exists' => false]);
    exit;
}

$sql = "SELECT user_id FROM user WHERE username = '" . $conn->real_escape_string($username) . "'";
$result = $conn->query($sql);

echo json_encode(['exists' => $result->num_rows > 0]);
