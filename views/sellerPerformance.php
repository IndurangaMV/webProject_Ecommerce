<?php
// Connect to database and start session
include "../config/connection.php";
include "../config/session.php";

if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
  header("Location: ../views/login.php");
  exit;
}

$seller_id = intval($_GET['id'] ?? 0);
if ($seller_id <= 0) {
  header("Location: ../views/sellerManagement.php");
  exit;
}

$sellerName = 'Seller';
$statusLabel = 'N/A';
$sellerStmt = $conn->prepare("SELECT username, COALESCE(status, 'N/A') AS status FROM user WHERE user_id = ? AND user_type = 2");
if ($sellerStmt) {
  $sellerStmt->bind_param('i', $seller_id);
  $sellerStmt->execute();
  $sellerResult = $sellerStmt->get_result();
  if ($sellerResult && $sellerRow = $sellerResult->fetch_assoc()) {
    $sellerName = $sellerRow['username'];
    $statusLabel = $sellerRow['status'];
  } else {
    header("Location: ../views/sellerManagement.php");
    exit;
  }
}

$hasSellerId = false;
$columnCheck = $conn->query("SHOW COLUMNS FROM product LIKE 'seller_id'");
if ($columnCheck && $columnCheck->num_rows > 0) {
  $hasSellerId = true;
}

$stats = [
  'total_products' => 0,
  'total_quantity' => 0,
  'average_price' => 0,
];

if ($hasSellerId) {
  $statsStmt = $conn->prepare("SELECT COUNT(*) AS total_products, COALESCE(SUM(qty),0) AS total_quantity, COALESCE(AVG(price),0) AS average_price FROM product WHERE seller_id = ?");
  if ($statsStmt) {
    $statsStmt->bind_param('i', $seller_id);
    $statsStmt->execute();
    $statsResult = $statsStmt->get_result();
    if ($statsResult) {
      $stats = $statsResult->fetch_assoc();
    }
  }
} else {
  $statsResult = $conn->query("SELECT COUNT(*) AS total_products, COALESCE(SUM(qty),0) AS total_quantity, COALESCE(AVG(price),0) AS average_price FROM product");
  if ($statsResult) {
    $stats = $statsResult->fetch_assoc();
  }
}

$productSql = "SELECT p.p_id, p.p_name, COALESCE(c.c_name, 'Uncategorized') AS category_name, p.price, p.qty FROM product p LEFT JOIN category c ON p.category = c.c_id";
if ($hasSellerId) {
  $productSql .= " WHERE p.seller_id = ? ORDER BY p.p_id ASC";
  $productStmt = $conn->prepare($productSql);
  if ($productStmt) {
    $productStmt->bind_param('i', $seller_id);
    $productStmt->execute();
    $productResult = $productStmt->get_result();
  }
} else {
  $productSql .= " ORDER BY p.p_id ASC";
  $productResult = $conn->query($productSql);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Seller Performance</title>
  <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<div class="container">
  <h1>Seller Performance for <?php echo htmlspecialchars($sellerName); ?></h1>
  <p>Status: <?php echo htmlspecialchars($statusLabel); ?></p>
  <?php if (!$hasSellerId): ?>
    <p><em>Seller-specific product linking is not available in the current database schema. Showing all products instead.</em></p>
  <?php endif; ?>
  <p>Total Products: <?php echo htmlspecialchars($stats['total_products']); ?></p>
  <p>Total Quantity in Stock: <?php echo htmlspecialchars($stats['total_quantity']); ?></p>
  <p>Average Price: <?php echo number_format((float)$stats['average_price'], 2); ?></p>

  <h2>Products</h2>
  <table>
    <tr>
      <th>Product ID</th><th>Name</th><th>Category</th><th>Price</th><th>Quantity</th>
    </tr>
    <?php if (!empty($productResult) && $productResult->num_rows > 0): ?>
      <?php while ($row = $productResult->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['p_id']); ?></td>
          <td><?php echo htmlspecialchars($row['p_name']); ?></td>
          <td><?php echo htmlspecialchars($row['category_name']); ?></td>
          <td><?php echo htmlspecialchars($row['price']); ?></td>
          <td><?php echo htmlspecialchars($row['qty']); ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">No products found.</td></tr>
    <?php endif; ?>
  </table>

  <br>
  <a href="sellerManagement.php">Back to Seller Management</a>
</div>
</body>
</html>
