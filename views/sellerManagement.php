<?php
// ======================
// CONNECTION + SESSION
// ======================
include "../config/connection.php";
include "../config/session.php";
include "partials/header.php";


// ======================
// ADMIN CHECK
// ======================
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
    header("Location: ../views/login.php");
    exit;
}


// ======================
// GET SEARCH VALUES
// ======================
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';


// ======================
// BASE QUERY (SELLERS ONLY)
// ======================
$sql = "
SELECT 
    user_id,
    username,
    email,
    contact_no,
    status
FROM user
WHERE user_type = 2
";


// ======================
// SEARCH FILTER
// ======================
if ($search != '') {
    $sql .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
}


// ======================
// STATUS FILTER
// ======================
if ($status != '') {
    $sql .= " AND status = '$status'";
}


// ======================
// SORT
// ======================
$sql .= " ORDER BY user_id ASC";

$result = $conn->query($sql);


// Status list
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

    <h2>Seller Management</h2>

    <!-- SEARCH + FILTER -->
    <form method="GET" class="search-form">

        <input type="text" name="search"
               placeholder="Search seller"
               value="<?php echo $search; ?>">

        <select name="status">

            <option value="">All Status</option>

            <?php foreach($statuses as $s){ ?>
                <option value="<?php echo $s; ?>"
                    <?php if($status == $s) echo "selected"; ?>>
                    <?php echo $s; ?>
                </option>
            <?php } ?>

        </select>

        <button type="submit" class="btn btn-dark">Filter</button>

    </form>

    <!-- SELLER TABLE -->
    <table>

        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php if($result->num_rows > 0){ ?>

            <?php while($row = $result->fetch_assoc()){ ?>

                <tr>

                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['contact_no']; ?></td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower($row['status']); ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>

                    <td>
                        <div class="action-buttons">

                            <!-- STATUS ACTIONS - BUTTONS -->
                            <a href="../controllers/changeSellerStatus.php?id=<?php echo $row['user_id']; ?>&action=approve" 
                               class="btn btn-success">Approve</a>

                            <a href="../controllers/changeSellerStatus.php?id=<?php echo $row['user_id']; ?>&action=reject" 
                               class="btn btn-danger">Reject</a>

                            <a href="../controllers/changeSellerStatus.php?id=<?php echo $row['user_id']; ?>&action=suspend" 
                               class="btn btn-warning">Suspend</a>

                            <a href="../controllers/changeSellerStatus.php?id=<?php echo $row['user_id']; ?>&action=activate" 
                               class="btn btn-info">Activate</a>

                            <!-- EXTRA FEATURES - BUTTONS -->
                            <a href="sellerProducts.php?id=<?php echo $row['user_id']; ?>" 
                               class="btn btn-purple">View Products</a>

                            <a href="sellerPerformance.php?id=<?php echo $row['user_id']; ?>" 
                               class="btn btn-dark">Performance</a>

                        </div>
                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="6">No sellers found</td>
            </tr>

        <?php } ?>

    </table>

    <br>
    <a href="dashboard.php" class="back-link">Back</a>

</div>

<?php include "partials/footer.php"; ?>

</body>
</html>