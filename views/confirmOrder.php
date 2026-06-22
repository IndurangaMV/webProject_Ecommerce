<?php

session_start();
require_once "../config/connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST["s_id"])) {

    $seller_id = $_SESSION["user_id"];
    $s_id = $_POST["s_id"];

    // Verify that this order belongs to this seller
    $sql = "
    SELECT s.s_id
    FROM selling s
    INNER JOIN product p
        ON s.product = p.p_id
    WHERE
        s.s_id = '$s_id'
        AND p.seller_id = '$seller_id'
    ";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $sql2 = "
        UPDATE selling
        SET order_status = 2
        WHERE s_id = '$s_id'
        ";

        $conn->query($sql2);
    }
}

header("Location: orders.php");
exit();

?>