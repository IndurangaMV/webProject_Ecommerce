<?php
// DATABASE + SESSION
include "../config/connection.php";
include "../config/session.php";
include "partials/header.php";


// ONLY ADMIN CAN ACCESS
if (!isset($_SESSION['user']) || $_SESSION['user_type'] != 1) {
    header("Location: ../views/login.php");
    exit;
}


// GET FILTER VALUES
$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';


// BASE QUERY (CUSTOMERS ONLY)
$sql = "
SELECT 
    u.user_id,
    u.username,
    u.email,
    u.contact_no,
    g.gender,
    u.status
FROM user u
LEFT JOIN gender g ON u.gender = g.gender_id
WHERE u.user_type = 3
";


// SEARCH FILTER
if ($search != '') {
    $sql .= " AND (u.username LIKE '%$search%' OR u.email LIKE '%$search%')";
}


// STATUS FILTER
if ($status != '') {
    $sql .= " AND u.status = '$status'";
}


// SORT
$sql .= " ORDER BY u.user_id ASC";


// EXECUTE QUERY
$result = $conn->query($sql);


// Status list for dropdown
$statuses = ['ACTIVE', 'INACTIVE', 'SUSPENDED', 'REJECTED'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>

<body>

<div class="container">

    <h2>Customer Management</h2>

    <!-- SEARCH + FILTER FORM -->
    <form method="GET" class="search-form">

        <input type="text" name="search"
               placeholder="Search username/email"
               value="<?php echo $search; ?>">

        <select name="status">
            <option value="">All Status</option>

            <?php foreach ($statuses as $s) { ?>
                <option value="<?php echo $s; ?>"
                    <?php if ($status == $s) echo "selected"; ?>>
                    <?php echo $s; ?>
                </option>
            <?php } ?>

        </select>

        <button type="submit" class="btn btn-dark">Filter</button>

    </form>

    <!-- CUSTOMER TABLE -->
    <table>

        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php if ($result->num_rows > 0) { ?>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <tr>

                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['contact_no']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower($row['status']); ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>

                    <td>
                        <div class="action-buttons">

                            <!-- Activate - Green Button -->
                            <a href="../controllers/changeCustomerStatus.php?id=<?php echo $row['user_id']; ?>&action=activate" 
                               class="btn btn-success">Activate</a>

                            <!-- Deactivate - Yellow Button -->
                            <a href="../controllers/changeCustomerStatus.php?id=<?php echo $row['user_id']; ?>&action=deactivate" 
                               class="btn btn-warning">Deactivate</a>

                            <!-- Delete - Red Button -->
                            <a href="../controllers/changeCustomerStatus.php?id=<?php echo $row['user_id']; ?>&action=delete" 
                               class="btn btn-danger">Delete</a>

                            <!-- View Profile - Blue Button -->
                            <a href="customerProfile.php?id=<?php echo $row['user_id']; ?>" 
                               class="btn btn-info">View</a>

                        </div>
                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="7">No customers found</td>
            </tr>

        <?php } ?>

    </table>

    <br>
    <a href="dashboard.php" class="back-link">Back to Dashboard</a>

</div>

<?php include "partials/footer.php"; ?>

</body>
</html>