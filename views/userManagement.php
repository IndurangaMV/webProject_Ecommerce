<?php
include "../config/session.php";
require_once "../config/connection.php";
// CHECK LOGIN
if (!isset($_SESSION["user"])) {
    header("Location: ../views/login.php");
    exit;
} else {
?>
    //put the code here for the dashboard page
<?php
}
?>