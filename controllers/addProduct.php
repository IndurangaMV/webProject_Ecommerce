<?php

// Start session
include "../config/session.php";

// Database connection
include "../config/connection.php";



// CHECK SELLER LOGIN

if(!isset($_SESSION["user"]) || $_SESSION["user_type"] != 2){

    header("Location: ../views/login.php");
    exit;

}



// GET FORM DATA


$productName = $_POST['p_name'];

$category = $_POST['category'];

$price = $_POST['price'];


// ---------------------GET SELLER ID---------------------


// Username stored in session

$username = $_SESSION['user'];

$query = $conn->query(
"
SELECT user_id
FROM user
WHERE username='$username'
"
);

$row = $query->fetch_assoc();

$seller_id = $row['user_id'];


// INSERT PRODUCT

$sql = "
INSERT INTO product
(
    p_name,
    price,
    category,
    seller_id
)
VALUES
(
    '$productName',
    '$price',
    '$category',
    '$seller_id'
)
";

// EXECUTE QUERY
if($conn->query($sql))
{

    header(
    "Location: ../views/addNewProduct.php?status=success&message=Product Added Successfully"
    );

}
else
{

    header(
    "Location: ../views/addNewProduct.php?status=error&message=Failed To Add Product"
    );

}

exit;

?>