<?php
include "../config/session.php";
require_once "../config/connection.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check the standard user session configuration
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user_role = isset($_SESSION['user_type']) ? (int)$_SESSION['user_type'] : 0;

if ($user_role !== 2) {
    // If they are a regular buyer (2) or role is unknown, redirect them to the buyer profile
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['user']);

// Initialize variables for form inputs
$firstname    = '';
$lastname     = '';
$email        = '';
$password_val = '';

// Query your shared 'user' table using the current session name
$query = "SELECT * FROM user WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($userData = $result->fetch_assoc()) {
        $firstname    = htmlspecialchars($userData['firstname'] ?? '');
        $lastname     = htmlspecialchars($userData['lastname'] ?? '');
        $email        = htmlspecialchars($userData['email'] ?? '');
        $password_val = htmlspecialchars($userData['password'] ?? '');
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Control Panel - Gamma Electronics</title>
    <link rel="stylesheet" href="../assests/css/userProfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



    <style>
        .content-section {
            display: none;
        }

        .content-section.active-content {
            display: block;
        }

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .metric-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .metric-card h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
        }

        .metric-card p {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
        }
    </style>
</head>

<body>

    <?php include 'partials/header.php'; ?>

    <div class="account-container">

        <div class="user-welcome-header">
            <form action="../config/uploadProfileImage.php" method="POST" enctype="multipart/form-data" id="pfpForm">
                <label for="pfpInput" class="welcome-avatar" style="cursor: pointer; position: relative; overflow: hidden; display: flex;">
                    <?php
                    // Fetch image using the cross-reference relational mapping
                    $imgQuery = "SELECT ui.path FROM user u 
                         LEFT JOIN user_image ui ON u.image_id = ui.id 
                         WHERE u.username = ? LIMIT 1";
                    $imgStmt = $conn->prepare($imgQuery);
                    $user_avatar = '';

                    if ($imgStmt) {
                        $imgStmt->bind_param("s", $_SESSION['user']);
                        $imgStmt->execute();
                        $imgResult = $imgStmt->get_result();
                        if ($imgData = $imgResult->fetch_assoc()) {
                            $user_avatar = $imgData['path'] ?? '';
                        }
                        $imgStmt->close();
                    }

                    if (!empty($user_avatar) && file_exists($user_avatar)): ?>
                        <img src="<?php echo $user_avatar; ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <i class="fa-solid fa-user"></i>
                    <?php endif; ?>

                    <div style="position: absolute; bottom: 0; background: rgba(0,0,0,0.6); width: 100%; font-size: 10px; color: #fff; text-align: center; padding: 2px 0;">Edit</div>
                </label>
                <input type="file" name="profile_image" id="pfpInput" accept="image/*" style="display: none;" onchange="document.getElementById('pfpForm').submit();">
            </form>

            <div class="welcome-text">
                <span class="greeting">Hello!</span>
                <h2 class="username"><?php echo $username; ?></h2>
            </div>
        </div>

        <div class="dashboard-layout">
            <aside class="account-sidebar">
                <ul class="sidebar-menu">
                    <li class="menu-item active" data-target="overview"><a href="#">OVERVIEW</a></li>
                    <li class="menu-item" data-target="productList"><a href="#">PRODUCTS</a></li>

                    <li class="menu-item" data-target="addNewProducts"><a href="addNewProduct.php">ADD NEW PRODUCTS</a></li>
                    <li class="menu-item" data-target="sales"><a href="orders.php">SALES ORDERS</a></li>
                    <li class="menu-item" data-target="details"><a href="#">ACCOUNT DETAILS</a></li>
                    <li class="menu-item"><a href="../config/logout.php">LOG OUT</a></li>
                </ul>
            </aside>

            <main class="account-main-content">

                <div id="section-overview" class="content-section active-content">
                    <p class="dashboard-intro">
                        Hello <strong><?php echo $username; ?></strong>
                        (not <strong><?php echo $username; ?></strong>?
                        <a href="../config/logout.php" class="link-alt">Log out</a>)
                    </p>

                    <p class="dashboard-text" style="margin-bottom: 30px;">
                        From your account dashboard you can view your <strong style="color: blue;">manage products</strong>, manage your <strong style="color: blue;">sales orders</strong>, and <strong style="color: blue;">edit your password and account details</strong>.
                    </p>

                </div>

                <div id="section-products" class="content-section">
                    <h2>Inventory Management</h2>
                    <p>This is where your list of active inventory products will render.</p>
                    <button class="save-changes-btn" style="background-color: #2b70c9;">+ Add New Product</button>
                </div>

                <div id="section-sales" class="content-section">
                    <h2>Customer Sales Orders</h2>
                    <p>This is where orders placed by clients for your items will appear for fulfillment.</p>
                </div>

                <div id="section-details" class="content-section">
                    <form action="../config/updateSellerAccount.php" method="POST" class="account-details-form">

                        <div class="form-row">
                            <div class="form-group">
                                <label>First name <span class="required">*</span></label>
                                <input type="text" name="firstname" value="<?php echo $firstname; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Last name <span class="required">*</span></label>
                                <input type="text" name="lastname" value="<?php echo $lastname; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Display name <span class="required">*</span></label>
                                <input type="text" name="displayname" value="<?php echo $username; ?>" required>
                                <small class="form-hint">This will be how your name will be displayed in the seller section and in reviews</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Email address <span class="required">*</span></label>
                                <input type="email" name="email" value="<?php echo $email; ?>" required>
                            </div>
                        </div>

                        <fieldset class="password-change-fieldset">
                            <legend>Password change</legend>

                            <div class="form-row">
                                <div class="form-group password-wrapper">
                                    <label>Current password (leave blank to leave unchanged)</label>
                                    <input type="password" name="current_password" value="<?php echo $password_val; ?>">
                                    <i class="fa-regular fa-eye toggle-password"></i>
                                </div>
                            </div>

                            <!-- <div class="form-row">
                                <div class="form-group password-wrapper">
                                    <label>New password (leave blank to leave unchanged)</label>
                                    <input type="password" name="new_password">
                                    <i class="fa-regular fa-eye toggle-password"></i>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group password-wrapper">
                                    <label>Confirm new password</label>
                                    <input type="password" name="confirm_password">
                                    <i class="fa-regular fa-eye toggle-password"></i>
                                </div>
                            </div>-->
                        </fieldset>

                        <button type="submit" class="save-changes-btn">Save changes</button>
                    </form>
                </div>

            </main>
        </div>
    </div>

    <?php include 'partials/footer.php'; ?>

    <script src="../assests/js/sellerProfile.js"></script>
</body>

</html>