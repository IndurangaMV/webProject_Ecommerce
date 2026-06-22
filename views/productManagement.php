<?php
include "../config/session.php";
include "../config/connection.php";

if (!isset($_SESSION["user"]) || $_SESSION["user_type"] != 1) {
    header("Location: ../views/login.php");
    exit;
}

$query = "SELECT p.p_id, p.p_name, COALESCE(c.c_name, 'Uncategorized') AS category_name, p.price, p.qty
          FROM product p
          LEFT JOIN category c ON p.category = c.c_id
          ORDER BY p.p_id ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<div class="container">
    <h1>Product Management</h1>

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
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
