<?php
include "../config/session.php";
require_once "../config/connection.php"; // Loaded securely once

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user session is missing
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user_role = isset($_SESSION['user_type']) ? (int)$_SESSION['user_type'] : 0;

if ($user_role !== 3) {
    // If they are a regular buyer (3) or role is unknown, redirect them to the buyer profile
    header("Location: login.php"); 
    exit();
}


$username = htmlspecialchars($_SESSION['user']);

// Initialize fallback variables for inputs
$firstname    = '';
$lastname     = '';
$displayname  = $username;
$email        = '';
$address      = '';
$district_id  = ''; 
$password_val = '';

// MySQLi Prepared Statement
$query = "SELECT * FROM user WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($userData = $result->fetch_assoc()) {
        $email        = htmlspecialchars($userData['email']);
        $displayname  = htmlspecialchars($userData['username']);
        $address      = htmlspecialchars($userData['address'] ?? '');
        $district_id  = htmlspecialchars($userData['district'] ?? '');
        $password_val = htmlspecialchars($userData['password']);
        
        // Split placeholder setup if actual separate columns aren't present yet
        $firstname    = htmlspecialchars($userData['firstname']); 
        $lastname     = htmlspecialchars($userData['lastname']);
    }
    $stmt->close();

}
// Put this right below your $stmt->close(); at the top of the file
$districts_list = [
    1 => "Colombo",
    2 => "Gampaha",
    3 => "Kalutara",
    4 => "Jaffna",
    5 => "Kilinochchi",
    6 => "Mulathivu",
    7 => "Mannar",
    8 => "Vavuniya",
    9 => "Thrincomalee",
    10 => "Batticaloa",
    11 => "Ampara",
    12 => "Galle",
    13 => "Matara",
    14 => "Hambantota",
    15 => "Badulla",
    16 => "Monaragala",
    17 => "Kegalle",
    18 => "Rathnapura",
    19 => "Kandy",
    20 => "Matale",
    21 => "Nuwara Eliya",
    22 => "Anuaradhapura",
    23 => "Polonnaruwa",
    24 => "Kurunegala",
    25 => "Puttalam",
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamma Electronics - My Account</title>
    <link rel="stylesheet" href="../assests/css/userProfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
    <script src="../assests/js/userProfile.js" defer></script>

    <style>
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
                        Hello <strong><?php echo $displayname; ?></strong> 
                        (not <strong><?php echo $displayname; ?></strong>? 
                        <a href="../config/logout.php" class="link-alt">Log out</a>)
                    </p>
                    <p class="dashboard-text">
                        From your account dashboard you can view your <strong style="color:blue;">recent orders</strong>, manage your <strong style="color:blue;">billing addresses</strong>, and <strong style="color:blue;">edit your password and account details</strong>.
                    </p>
                </div>

                <div id="section-orders" class="content-section">
                    <h2>Orders</h2>
                    <p>This is orders.</p>
                </div>

                <div id="section-addresses" class="content-section">
                    <p class="addresses-intro">The following addresses will be used on the checkout page by default.</p>
                    
                    <form action="../config/updateUserAddress.php" method="POST" class="account-details-form">
                        <h3 class="address-form-heading">Billing address</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Address <span class="required">*</span></label>
                                <input type="text" name="street_address" value="<?php echo $address; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>District <span class="required">*</span></label>
                                <select name="district" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1;">
                                    <option value="">-- Select Your District --</option>
                                    <?php foreach ($districts_list as $id => $name): ?>
                                        <option value="<?php echo $id; ?>" <?php echo ((int)$district_id === $id) ? 'selected' : ''; ?>>
                                            <?php echo $name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="save-changes-btn" style="margin-top: 15px;">Save changes</button>
                    </form>
                </div>

                <div id="section-details" class="content-section">
                    <form action="../config/updateUserAccount.php" method="POST" class="account-details-form">
                        
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
                                <input type="text" name="displayname" value="<?php echo $displayname; ?>" required>
                                <small class="form-hint">This will be how your name will be displayed in the account section and in reviews</small>
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