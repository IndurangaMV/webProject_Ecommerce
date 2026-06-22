<?php
include "../config/session.php";
require_once "../config/connection.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$current_user = $_SESSION["user"];
$user_type = $_SESSION["user_type"];

// Non-admin users get the old simple view
if ($user_type != 1) {
    ?>
    <!DOCTYPE html>
    <html>
    <head><title>Dashboard</title></head>
    <body style="font-family:Arial,sans-serif;padding:20px;">
        <h1>Welcome <?php echo htmlspecialchars($current_user); ?></h1>
        <?php if ($user_type == 2) { ?>
            <a href="addNewProduct.php">Add new Product</a><br>
            <a href="sellerProfile.php">Seller Profile</a>
        <?php } else { ?>
            <a href="userProfile.php">User Profile</a><br>
            <a href="index.php">Home</a>
        <?php } ?>
        <br><a href="../config/logout.php">Logout</a>
    </body>
    </html>
    <?php
    exit;
}

// Admin analytics queries
$total_customers = 0;
$total_sellers = 0;
$total_products = 0;
$total_categories = 0;
$recent_users = null;

$result = $conn->query("SELECT COUNT(*) AS c FROM user WHERE user_type = 3");
if ($result) { $total_customers = (int)$result->fetch_assoc()['c']; }

$result = $conn->query("SELECT COUNT(*) AS c FROM user WHERE user_type = 2");
if ($result) { $total_sellers = (int)$result->fetch_assoc()['c']; }

$result = $conn->query("SELECT COUNT(*) AS c FROM product");
if ($result) { $total_products = (int)$result->fetch_assoc()['c']; }

$result = $conn->query("SELECT COUNT(*) AS c FROM category");
if ($result) { $total_categories = (int)$result->fetch_assoc()['c']; }

$recent_users = $conn->query("SELECT username, email, user_type, status FROM user ORDER BY user_id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Gamma Electronics</title>
    <link rel="stylesheet" href="../assests/css/dashboard.css">
</head>
<body>

    <header class="topbar">
        <div class="topbar-left">
            <img src="../assests/images/login/logo.png" alt="Gamma Electronics" class="topbar-logo">
            <span class="topbar-brand">GAMMA ELECTRONICS</span>
        </div>
        <div class="topbar-right">
            <span class="topbar-user">👤 Welcome, <?php echo htmlspecialchars($current_user); ?>!</span>
            <a href="../config/logout.php" class="topbar-logout">🚪 Logout</a>
        </div>
    </header>

    <div class="sidebar-area">
        <div class="sidebar-hint">☰</div>
        <nav class="sidebar">
            <div class="sidebar-header">
                <img src="../assests/images/login/logo.png" alt="" class="sidebar-logo">
                <span>Admin Panel</span>
            </div>
            <a href="dashboard.php" class="sidebar-item active">📊 Dashboard</a>
            <a href="customerManagement.php" class="sidebar-item">👥 Customer Management</a>
            <a href="sellerManagement.php" class="sidebar-item">🏪 Seller Management</a>
            <a href="productManagement.php" class="sidebar-item">📦 Product Management</a>
            <a href="userManagement.php" class="sidebar-item">⚙️ Admin Dashboard</a>
        </nav>
    </div>

    <main class="main-content">
        <h2 class="page-title">📊 Dashboard Overview</h2>

        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="card-icon customers">👥</div>
                <div class="card-info">
                    <span class="card-number"><?php echo $total_customers; ?></span>
                    <span class="card-label">Total Customers</span>
                </div>
            </div>
            <div class="analytics-card">
                <div class="card-icon sellers">🏪</div>
                <div class="card-info">
                    <span class="card-number"><?php echo $total_sellers; ?></span>
                    <span class="card-label">Total Sellers</span>
                </div>
            </div>
            <div class="analytics-card">
                <div class="card-icon products">📦</div>
                <div class="card-info">
                    <span class="card-number"><?php echo $total_products; ?></span>
                    <span class="card-label">Total Products</span>
                </div>
            </div>
            <div class="analytics-card">
                <div class="card-icon categories">🏷️</div>
                <div class="card-info">
                    <span class="card-number"><?php echo $total_categories; ?></span>
                    <span class="card-label">Categories</span>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <div class="content-card">
                <h3>⚡ Quick Actions</h3>
                <div class="actions-grid">
                    <a href="customerManagement.php" class="action-btn">👥 Customers</a>
                    <a href="sellerManagement.php" class="action-btn">🏪 Sellers</a>
                    <a href="productManagement.php" class="action-btn">📦 Products</a>
                </div>
            </div>

            <div class="content-card">
                <h3>👤 Recent Users</h3>
                <?php if ($recent_users && $recent_users->num_rows > 0): ?>
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $recent_users->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php
                                $t = (int)$row['user_type'];
                                echo $t === 1 ? 'Admin' : ($t === 2 ? 'Seller' : 'Customer');
                            ?></td>
                            <td><span class="status-badge <?php echo strtolower(htmlspecialchars($row['status'])); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color:#94a3b8;font-size:0.9rem;">No users found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

</body>
</html>