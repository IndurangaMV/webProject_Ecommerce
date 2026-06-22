<?php
include "../config/session.php";
require_once "../config/connection.php";

if(!isset($_SESSION["user"]) || $_SESSION["user_type"] != 3){
    header("Location: ../views/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../views/index.php");
    exit;
}

$pid = intval($_POST["pid"]);
$qty = intval($_POST["qty"]);
$name = $_POST["name"];
$contact = $_POST["contact"];
$address = $_POST["address"];
$email = $_POST["email"];

$sql = "SELECT * FROM product WHERE p_id='$pid'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: ../views/index.php");
    exit;
}

$product = $result->fetch_assoc();

$total = $qty * $product["price"];
$seller_id = $product["seller_id"];
$prev_qty = $product["qty"];

$currentTime = date("Y-m-d H:i:s");

/* ---------------- PDF GENERATION ---------------- */

require("../libs/fpdf/fpdf.php");

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont("Arial","B",16);
$pdf->Cell(190,10,"INVOICE",0,1,"C");

$pdf->Ln(10);

$pdf->SetFont("Arial","",12);
$pdf->Cell(100,10,"Product ID: ".$pid,0,1);
$pdf->Cell(100,10,"Quantity: ".$qty,0,1);
$pdf->Cell(100,10,"Customer: ".$name,0,1);
$pdf->Cell(100,10,"Contact: ".$contact,0,1);
$pdf->Cell(100,10,"Address: ".$address,0,1);

$pdf->Ln(10);

$pdf->SetFont("Arial","B",14);
$pdf->Cell(100,10,"Total: Rs. ".$total,0,1);

$fileName = "invoice_".time().".pdf";
$filePath = "../invoices/".$fileName;

$pdf->Output("F", $filePath);

/* ---------------- SAVE INVOICE ---------------- */

$sql_saveInvoice = "INSERT INTO invoice(path,date,amount,type)
VALUES('$filePath','$currentTime','$total','1')";

$conn->query($sql_saveInvoice);
$invoice_id = $conn->insert_id;

/* ---------------- SELLING RECORD ---------------- */

$sql_saveSellingRecord = "INSERT INTO selling 
(user,product,quantity,date,amount,invoice,order_status)
VALUES
('{$_SESSION["user_id"]}','$pid','$qty','$currentTime','$total','$invoice_id','1')";

$conn->query($sql_saveSellingRecord);

/* ---------------- UPDATE STOCK ---------------- */

$sql_qtyUpdate = "UPDATE product 
SET qty = qty - $qty 
WHERE p_id = $pid";

$conn->query($sql_qtyUpdate);

/* ---------------- NOTIFICATION ---------------- */

$sql_notification = "INSERT INTO message(message,time,sender,receiver,seen)
VALUES
('New order received','$currentTime','1','$seller_id','1')";

$conn->query($sql_notification);

/* ---------------- FINAL REDIRECT ---------------- */

header("Location: ../views/index.php");
exit;
?>