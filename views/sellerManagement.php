<?php
// Connect to database and start session
include "../config/connection.php";
include "../config/session.php";

// Only allow admin access
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
  header("Location: ../views/login.php");
  exit;
}

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');

$query = "SELECT u.user_id, u.username, u.email, u.contact_no, COALESCE(u.status, 'N/A') AS status
          FROM user u
          WHERE u.user_type = 2";

$bindTypes = '';
$bindParams = [];

if ($search !== '') {
  $query .= " AND (u.username LIKE ? OR u.email LIKE ? )";
  $bindTypes .= 'ss';
  $bindParams[] = "%$search%";
  $bindParams[] = "%$search%";
}

if ($status !== '') {
  $query .= " AND u.status = ?";
  $bindTypes .= 's';
  $bindParams[] = $status;
}

$query .= " ORDER BY u.user_id ASC";

$stmt = $conn->prepare($query);
$result = false;
if ($stmt) {
  if ($bindTypes !== '') {
    if ($bindTypes === 's') {
      $stmt->bind_param('s', $bindParams[0]);
    } elseif ($bindTypes === 'ss') {
      $stmt->bind_param('ss', $bindParams[0], $bindParams[1]);
    } elseif ($bindTypes === 'sss') {
      $stmt->bind_param('sss', $bindParams[0], $bindParams[1], $bindParams[2]);
    }
  }
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query($query);
}

$statuses = ['ACTIVE', 'INACTIVE', 'SUSPENDED', 'REJECTED'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Seller Management</title>
  <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<div class="container">
  <h1>Seller Management</h1>

  <form method="get" class="action-buttons">
    <input type="text" name="search" placeholder="Search by username or email" value="<?php echo htmlspecialchars($search); ?>">
    <select name="status">
      <option value="">All statuses</option>
      <?php foreach ($statuses as $option): ?>
        <option value="<?php echo $option; ?>" <?php echo $status === $option ? 'selected' : ''; ?>><?php echo $option; ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
  </form>

  <table>
    <tr>
      <th>ID</th><th>Username</th><th>Email</th><th>Contact</th><th>Status</th><th>Actions</th>
    </tr>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['user_id']); ?></td>
          <td><?php echo htmlspecialchars($row['username']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td><?php echo htmlspecialchars($row['contact_no']); ?></td>
          <td><?php echo htmlspecialchars($row['status']); ?></td>
          <td>
            <div class="action-buttons">
              <a href="../controllers/changeSellerStatus.php?id=<?php echo $row['user_id']; ?>&action=approve" class="add-btn">Approve</a>
              <a href="../controllers/changeSellerStatus.php?id=<?php echo $row['user_id']; ?>&action=reject" class="delete-btn">Reject</a>
              <a href="../controllers/changeSellerStatus.php?id=<?php echo $row['user_id']; ?>&action=suspend" class="delete-btn">Suspend</a>
              <a href="../controllers/changeSellerStatus.php?id=<?php echo $row['user_id']; ?>&action=activate" class="add-btn">Activate</a>
              <a href="../views/sellerProducts.php?id=<?php echo $row['user_id']; ?>" class="view-btn">View Products</a>
              <a href="../views/sellerPerformance.php?id=<?php echo $row['user_id']; ?>" class="view-btn">Performance</a>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="6">No sellers found.</td>
      </tr>
    <?php endif; ?>
  </table>
  <br>
  <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
