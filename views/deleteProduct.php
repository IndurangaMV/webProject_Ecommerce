<?php
include "../config/session.php";
require_once "../config/connection.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $updateQuery = "UPDATE product_has_seller SET admin_status_as_id = 2 WHERE product_id = $id";

    if ($conn->query($updateQuery)) {
        echo "<script>alert('Product Rejected Successfully'); window.location.href='productManagement.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to reject'); window.location.href='productManagement.php';</script>";
    }
}
?>