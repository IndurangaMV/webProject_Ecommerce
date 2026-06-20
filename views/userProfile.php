<?php
include "../config/session.php";
require_once "../config/connection.php";
// CHECK LOGIN

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamma Electronics - My Account</title>
    <link rel="stylesheet" href="../assests/css/userProfile.css">
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
    
    <script src="../assests/js/userProfile.js" defer></script>

    <style>
        /* CSS utility to toggle section visibility smoothly */
        .content-section {
            display: none;
        }
        .content-section.active-content {
            display: block;
        }
    </style>
</head>
<body>

    <?php include 'partials/header.php'; ?>

    <div class="account-container">
        
        <div class="user-welcome-header">
            <div class="welcome-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="welcome-text">
                <span class="greeting">Hello!</span>
                <h2 class="username"><?php echo $username; ?></h2>
            </div>
        </div>

        <div class="dashboard-layout">
            <aside class="account-sidebar">
                <ul class="sidebar-menu">
                    <li class="menu-item active" data-target="dashboard"><a href="#">DASHBOARD</a></li>
                    <li class="menu-item" data-target="orders"><a href="#">ORDERS</a></li>
                    <li class="menu-item" data-target="addresses"><a href="#">ADDRESSES</a></li>
                    <li class="menu-item" data-target="details"><a href="#">ACCOUNT DETAILS</a></li>
                    <li class="menu-item"><a href="../config/logout.php">LOG OUT</a></li>
                </ul>
            </aside>

            <main class="account-main-content">
                
                <div id="section-dashboard" class="content-section active-content">
                    <p class="dashboard-intro">
                        Hello <strong><?php echo $username; ?></strong> 
                        (not <strong><?php echo $username; ?></strong>? 
                        <a href="../config/logout.php" class="link-alt">Log out</a>)
                    </p>
                    <p class="dashboard-text">
                        From your account dashboard you can view your <a href="#">recent orders</a>, manage your <a href="#">shipping and billing addresses</a>, and <a href="#">edit your password and account details</a>.
                    </p>
                </div>

                <div id="section-orders" class="content-section">
                    <h2>Orders</h2>
                    <p>This is orders.</p>
                </div>

         
<div id="section-addresses" class="content-section">
    <p class="addresses-intro">The following addresses will be used on the checkout page by default.</p>
    
    <form action="../config/updateAddress.php" method="POST" class="account-details-form">
        <h3 class="address-form-heading">Billing address</h3>

        <div class="form-row">
            <div class="form-group">
                <label>Street address <span class="required">*</span></label>
                <input type="text" name="street_address" value="97, Mahawatthe" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Town / City <span class="required">*</span></label>
                <input type="text" name="city" value="Kotugoda" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Province <span class="required">*</span></label>
                <input type="text" name="province" value="Western Province" required>
            </div>
        </div>

        <button type="submit" class="save-changes-btn">Save changes</button>
    </form>
</div>

                <div id="section-details" class="content-section">
    <form action="../config/updateAccount.php" method="POST" class="account-details-form">
        
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
                <input type="text" name="displayname" value="<?php echo $username; ?>" required>
                <small class="form-hint">This will be how your name will be displayed in the account section and in reviews</small>
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

</body>
</html>