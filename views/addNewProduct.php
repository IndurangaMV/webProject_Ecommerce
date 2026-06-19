<?php

// Start session
include "../config/session.php";

// Check seller login
if(!isset($_SESSION["user"]) || $_SESSION["user_type"] != 2){
    header("Location: ../views/login.php");
    exit;
}

// Database connection
include "../config/connection.php";

// Get all categories
$result = $conn->query("SELECT * FROM category");

// Success/Error messages
$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';

include 'partials/header.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>

<body>

<div class="container">

    <h2>Add New Product</h2>

    <!-- Display message -->

    <?php if($status == "success"){ ?>

        <p><?php echo $message; ?></p>

    <?php } ?>

    <?php if($status == "error"){ ?>

        <p><?php echo $message; ?></p>

    <?php } ?>


    <!-- Add Product Form -->

    <form action="../controllers/addProduct.php" method="POST">

        <!-- Product Name -->

        <label>Product Name</label>

        <input
            type="text"
            name="p_name"
            required
        >

        <br><br>

        <!-- Category -->

        <label>Category</label>

        <select name="category" required>

            <option value="">Select Category</option>

            <?php while($row = $result->fetch_assoc()){ ?>

                <option value="<?php echo $row['c_id']; ?>">

                    <?php echo $row['c_name']; ?>

                </option>

            <?php } ?>

        </select>

        <br><br>

        <!-- Price -->

        <label>Price</label>

        <input
            type="number"
            name="price"
            step="0.01"
            required
        >

        <br><br>

        <button type="submit">
            Add Product
        </button>

    </form>

    <br>

    <a href="dashboard.php">
        Back to Dashboard
    </a>

</div>

<?php include 'partials/footer.php'; ?>

</body>
</html>