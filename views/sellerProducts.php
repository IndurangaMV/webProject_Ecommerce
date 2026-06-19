<?php
// Connect to database
include "../config/connection.php";

$seller_id = intval($_GET['id'] ?? 0);

$sellerName = 'Seller';
$sellerStmt = $conn->prepare("SELECT username FROM user WHERE user_id = ? AND user_type = 2");
if ($sellerStmt) {
  $sellerStmt->bind_param('i', $seller_id);
  $sellerStmt->execute();
  $sellerResult = $sellerStmt->get_result();
  if ($sellerResult && $sellerRow = $sellerResult->fetch_assoc()) {
    $sellerName = $sellerRow['username'];
  }
}

$hasSellerId = false;
$columnCheck = $conn->query("SHOW COLUMNS FROM product LIKE 'seller_id'");
if ($columnCheck && $columnCheck->num_rows > 0) {
  $hasSellerId = true;
}

$sql = "SELECT p.p_id, p.p_name, COALESCE(c.c_name, 'Uncategorized') AS category_name, p.price, p.qty"
      ." FROM product p"
      ." LEFT JOIN category c ON p.category = c.c_id";

if ($hasSellerId) {
  $sql .= " WHERE p.seller_id = ?";
  $stmt = $conn->prepare($sql);
  if ($stmt) {
    $stmt->bind_param('i', $seller_id);
    $stmt->execute();
    $result = $stmt->get_result();
  }
} else {
  $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Seller Products</title>
  <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<div class="container">
  <h1>Seller Products for <?php echo htmlspecialchars($sellerName); ?></h1>

  <?php if (!$hasSellerId): ?>
    <p><em>Seller-specific product linking is not available in the current database schema. Showing all products instead.</em></p>
  <?php endif; ?>

  <table>
    <tr>
      <th>Product ID</th><th>Name</th><th>Category</th><th>Price</th><th>Quantity</th>
    </tr>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['p_id']); ?></td>
          <td><?php echo htmlspecialchars($row['p_name']); ?></td>
          <td><?php echo htmlspecialchars($row['category_name']); ?></td>
          <td><?php echo htmlspecialchars($row['price']); ?></td>
          <td><?php echo htmlspecialchars($row['qty']); ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="5">No products found.</td>
      </tr>
    <?php endif; ?>
  </table>

  <br>
  <a href="sellerManagement.php">Back to Seller Management</a>
</div>
</body>
</html>
<?php

include "../config/session.php";
include "../config/connection.php";

if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
    header("Location: ../views/login.php");
    exit;
}

$seller_id = $_GET['id'] ?? 0;

if ($seller_id <= 0) {
    header("Location: sellerManagement.php");
    exit;
}


// GET SELLER NAME
$seller = $conn->query("SELECT username FROM user WHERE user_id=$seller_id")->fetch_assoc();
$sellerName = $seller['username'];


// GET PRODUCTS
$products = $conn->query("
SELECT p.p_id, p.p_name, c.c_name, p.price
FROM product p
LEFT JOIN category c ON p.category = c.c_id
WHERE p.seller_id=$seller_id
ORDER BY p.p_id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Products</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>

<body>

<div class="container">

    <div class="page-header">
        <div>
            <h2>Products - <?php echo $sellerName; ?></h2>
            <p class="subtitle">View all products listed by this seller</p>
        </div>
        <a href="sellerManagement.php" class="btn btn-dark">← Back</a>
    </div>

    <?php if($products->num_rows > 0): ?>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = $products->fetch_assoc()){ ?>

                <tr>
                    <td><?php echo $row['p_id']; ?></td>
                    <td><span class="product-name"><?php echo $row['p_name']; ?></span></td>
                    <td><span class="category-badge"><?php echo $row['c_name']; ?></span></td>
                    <td><span class="price-tag">LKR <?php echo number_format($row['price'], 2); ?></span></td>
                </tr>

                <?php } ?>
            </tbody>

        </table>

    <?php else: ?>

        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3>No Products Found</h3>
            <p>This seller hasn't added any products yet.</p>
        </div>

    <?php endif; ?>

</div>

</body>
</html>