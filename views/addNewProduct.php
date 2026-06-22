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

    
    <!-- ALERT MESSAGES WITH CSS CLASSES            -->
    

    <?php if($status == "success"){ ?>
        <div class="alert alert-success">
            ✅ <?php echo $message; ?>
        </div>
    <?php } ?>

    <?php if($status == "error"){ ?>
        <div class="alert alert-error">
            ❌ <?php echo $message; ?>
        </div>
    <?php } ?>

    <!-- ADD PRODUCT FORM WITH CSS CLASSES          -->
    

    <form action="../controllers/addProduct.php" method="POST" class="product-form">

        <!-- Product Name -->
        <label>Product Name</label>
        <input type="text" name="p_name" required>

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

        <!-- Price -->
        <label>Price (LKR)</label>
        <input type="number" name="price" step="0.01" required>

        <label>Quantity</label>
        <input type="number" name="qty" required min="1">

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Add Product</button>

    </form>

    <br>

    <!-- Back Link -->
    <a href="sellerProfile.php" class="back-link">Back to Dashboard</a>

</div>

<?php include 'partials/footer.php'; ?>

</body>
</html>