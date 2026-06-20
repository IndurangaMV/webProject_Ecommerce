<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Checking if a seller session exists, falling back to 'Seller Admin'
$sellerName = isset($_SESSION['seller_name']) ? htmlspecialchars($_SESSION['seller_name']) : 'Gamma Partner';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Control Panel - Gamma Electronics</title>
    <link rel="stylesheet" href="../assests/css/userProfile.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .content-section { display: none; }
        .content-section.active-content { display: block; }
        
        /* Quick custom additions for seller metric cards */
        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .metric-card { background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px; text-align: center; }
        .metric-card h3 { margin: 0 0 10px 0; font-size: 14px; color: #64748b; text-transform: uppercase; }
        .metric-card p { margin: 0; font-size: 24px; font-weight: bold; color: #0f172a; }
    </style>
</head>
<body>

    <?php include 'partials/header.php'; ?>

    <div class="account-container">
        
        <!--<div class="user-welcome-header" style="background: linear-gradient(135deg, #1e293b, #0f172a); color: #fff; border-radius: 16px; padding: 24px;">
            <div class="welcome-avatar" style="background: rgba(255,255,255,0.1);">
                <i class="fa-solid fa-store" style="color: #38bdf8;"></i>
            </div>
            <div class="welcome-text">
                <span class="greeting" style="color: #94a3b8;">Seller Center</span>
                <h2 class="username" style="color: #fff;"><?php echo $sellerName; ?></h2>
            </div>
        </div>-->

        <div class="dashboard-layout">
            <aside class="account-sidebar">
                <ul class="sidebar-menu">
                    <li class="menu-item active" data-target="overview"><a href="#">OVERVIEW</a></li>
                    <li class="menu-item" data-target="products"><a href="#">MANAGE PRODUCTS</a></li>
                    <li class="menu-item" data-target="sales"><a href="#">SALES ORDERS</a></li>
                    <li class="menu-item" data-target="details"><a href="#">ACCOUNT DETAILS</a></li>
                    <li class="menu-item"><a href="../config/logout.php">LOG OUT</a></li>
                </ul>
            </aside>

            <main class="account-main-content">
                
                <div id="section-overview" class="content-section active-content">
                    <h2>Dashboard Overview</h2>
                    <div class="metrics-grid">
                        <div class="metric-card"><h3>Total Sales</h3><p>LKR 0.00</p></div>
                        <div class="metric-card"><h3>Orders Received</h3><p>0</p></div>
                        <div class="metric-card"><h3>Live Products</h3><p>0</p></div>
                    </div>
                    <p>Welcome to your merchant portal. Use the navigation sidebar to list items and review customer purchases.</p>
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
                                <input type="text" name="firstname" value="Teshan" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Last name <span class="required">*</span></label>
                                <input type="text" name="lastname" value="Thevindu" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Display name <span class="required">*</span></label>
                                <input type="text" name="displayname" value="<?php echo $sellerName; ?>" required>
                                <small class="form-hint">This will be how your name will be displayed in the seller section and in reviews</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Email address <span class="required">*</span></label>
                                <input type="email" name="email" value="teshan318@gmail.com" required>
                            </div>
                        </div>

                        <fieldset class="password-change-fieldset">
                            <legend>Password change</legend>

                            <div class="form-row">
                                <div class="form-group password-wrapper">
                                    <label>Current password (leave blank to leave unchanged)</label>
                                    <input type="password" name="current_password" value="********">
                                    <i class="fa-regular fa-eye toggle-password"></i>
                                </div>
                            </div>

                            <div class="form-row">
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
                            </div>
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