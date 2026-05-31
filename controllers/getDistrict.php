<?php
require '../config/connection.php';

$province_id = (int)$_GET['province_id'];

$sql = "SELECT * FROM district WHERE province_pr_id = '" . $province_id . "'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['d_id']}'>{$row['district']}</option>";
}
?>