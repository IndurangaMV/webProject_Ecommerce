<?php

session_start();
require_once "../config/connection.php";

// Protect page
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}

$seller_id = $_SESSION["user_id"];

$sql = "
SELECT
    s.s_id,
    s.quantity,
    s.date,
    s.amount,
   
    p.p_name,
    u.firstname,
    u.lastname,
    u.contact_no,
    u.address

FROM selling s

INNER JOIN product p
    ON s.product = p.p_id

INNER JOIN user u
    ON s.user = u.user_id

WHERE
    p.seller_id = '$seller_id'
    AND s.order_status = 1

ORDER BY s.date DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Pending Orders</title>

        <link rel="stylesheet" href="../assests/css/orders.css">


</head>

<body>

    <h1>Pending Orders</h1>

    <table>

        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Customer Name</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>action</th>
        </tr>

        <?php

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

        ?>

                <tr>

                    <td><?php echo $row["s_id"]; ?></td>

                    <td><?php echo $row["p_name"]; ?></td>

                    <td><?php echo $row["quantity"]; ?></td>

                    <td>
                        <?php echo $row["firstname"] . " " . $row["lastname"]; ?>
                    </td>

                    <td><?php echo $row["contact_no"]; ?></td>

                    <td><?php echo $row["address"]; ?></td>

                    <td>
                        <form action="confirmOrder.php" method="post">
                            <input type="hidden" name="s_id"
                                value="<?php echo $row["s_id"]; ?>">
                            <button type="submit">Confirm Order</button>
                        </form>
                    </td>

                </tr>

            <?php
            }
        } else {

            ?>

            <tr>
                <td colspan="6">No pending orders found.</td>
            </tr>

        <?php

        }

        ?>

    </table>

</body>

</html>