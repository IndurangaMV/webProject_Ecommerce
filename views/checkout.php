<?php
include "../config/session.php";
require_once "../config/connection.php";

if(!isset($_SESSION["user"]) || $_SESSION["user_type"] != 3){
    header("Location: ../views/login.php");
    exit;
}

if (!isset($_POST["pid"]) || !isset($_POST["qty"])) {
    header("Location: index.php");
    exit;
}

$pid = intval($_POST["pid"]);
$qty = intval($_POST["qty"]);

// GET PRODUCT + SELLER
$sql = "SELECT 
            product.*,
            user.username AS seller_name
        FROM product
        LEFT JOIN user 
            ON product.seller_id = user.user_id
        WHERE product.p_id = $pid";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Product not found";
    exit;
}

$product = $result->fetch_assoc();

$unit_price = $product["price"];
$total = $unit_price * $qty;

$sql2 = "SELECT user.*,district.district,province.province FROM user LEFT JOIN district ON 
user.district=district.d_id LEFT JOIN province ON district.province_pr_id=province.pr_id
 WHERE user_id='" . $_SESSION["user_id"] . "';";
$result2 = $conn->query($sql2);
if ($result2->num_rows == 0) {
    echo "User Data can't be loaded.";
    exit;
}
$user = $result2->fetch_assoc();
$username = $user["username"];
$email = $user["email"];
$contact = $user["contact_no"];
$address = $user["address"] . ", " . $user["district"] . ", " . $user["province"] . ".";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="../assests/css/checkout.css">
</head>

<body>

    <div class="checkout-container">

        <!-- PRODUCT SUMMARY -->
        <div class="box">
            <h2>Product Summary</h2>

            <div class="row">
                <span>Product Name</span>
                <span><?php echo $product["p_name"]; ?></span>
            </div>

            <div class="row">
                <span>Seller</span>
                <span><?php echo $product["seller_name"]; ?></span>
            </div>

            <div class="row">
                <span>Quantity</span>
                <span><?php echo $qty; ?></span>
            </div>

            <div class="row">
                <span>Unit Price</span>
                <span>Rs. <?php echo number_format($unit_price, 2); ?></span>
            </div>

            <div class="row total">
                <span>Total Amount</span>
                <span>Rs. <?php echo number_format($total, 2); ?></span>
            </div>
        </div>

        <!-- USER DETAILS -->
        <div class="box">
            <h2>User Details</h2>

            <form id="checkoutForm" action="../controllers/checkoutProcess.php" method="POST">

                <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                <input type="hidden" name="qty" value="<?php echo $qty; ?>">

                <label>Name</label>
                <input type="text" name="name" value="<?php echo $username ?>" required>

                <label>Email</label>
                <input type="text" name="email" value="<?php echo $email ?>" required>

                <label>Contact Number</label>
                <input type="text" name="contact" value="<?php echo $contact ?>" required>

                <label>Address</label>
                <textarea name="address" required><?php echo $address ?></textarea>

                <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                <input type="hidden" name="qty" value="<?php echo $qty; ?>">

                <!-- PAYMENT -->
                <div class="cod">
                    Payment Method: <b>Cash on Delivery</b>
                </div>

                <button class="btn" type="submit">
                    Checkout Now
                </button>

            </form>
        </div>

    </div>
<script>
//     document.getElementById("checkoutForm").addEventListener("submit", function(e) {
//     e.preventDefault(); // STOP page reload

//     let formData = new FormData(this);

//     fetch("../controllers/checkoutProcess.php", {
//         method: "POST",
//         body: formData
//     })
//     .then(res => res.json())
//     .then(data => {

//         alert(data.message);

//         if (data.status === "success") {
//             console.log("PID:", data.pid);
//             console.log("QTY:", data.qty);
//             console.log("name:",data.name)

//             // optional redirect
//             // window.location = "invoice.php?id=" + data.pid;
//         }

//     })
//     .catch(error => {
//         alert("Error occurred :"+error);
//     });
// });
</script>
</body>

</html>