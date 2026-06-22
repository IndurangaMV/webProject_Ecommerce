<?php
include "../config/session.php";
require_once "../config/connection.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="../assests/css/login.css">
    <script src="../assests/js/login.js" defer></script>
    <script src="../assests/js/register.js" defer></script>
</head>

<body>

    <?php include 'partials/header.php'; ?>

    <main class="auth-home">

        <h1>Welcome to Gamma</h1>
        <p>Please Login Or Register.</p>

        <!-- Login Popup -->
        <div id="loginModal" class="modal">

            <div class="modal-content">

                <span class="close" id="closeLogin">&times;</span>

                <h2>Login</h2>

                <form action="../config/auth.php" method="post">

                    <label>Username</label>
                    <input type="text" name="username" required>

                    <label>Password</label>
                    <input type="password" name="password" required>

                    <button class="button1" type="submit">Login</button>
                    <label for="registerBtn" style="margin-top: 10px;color:red;font-weight:100">Don't you have an Account?</label>
                    <button type="button" id="registerBtn" class="button2">Register</button>

                </form>

            </div>

        </div>

        <!-- Register Popup -->
        <div id="registerModal" class="modal">

            <div class="modal-content">

                <span class="close" id="closeRegister">&times;</span>

                <h2>Create Account</h2>

                <form action="../config/register.php" method="post" novalidate>
                    <div id="registerMessage" class="form-message" style="display:none;"></div>

                    <label>First Name</label>
                    <input type="text" name="firstName" required>

                    <label>Last Name</label>
                    <input type="text" name="lastName" required>

                    <label>Username</label>
                    <input type="text" name="username" required>

                    <label>Email</label>
                    <input type="email" name="email" required>

                    <label>Contact Number</label>
                    <input type="tel" name="contact" required>

                    <label>Address</label>
                    <input type="text" name="address" required>

                    <label>Province</label>
                    <select id="province" name="province" required>
                    <option value="" selected disabled>Select Province</option>
                        <?php                    
                        $sql = "SELECT * FROM province";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <option value='<?php echo $row["pr_id"] ?>'><?php echo $row["province"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <select id="district" name="district" required>
                        <option value="" selected disabled>Select District</option>
                    </select>

                    <label>Postal Code</label>
                    <input type="number" name="postalCode" required>

                    <label>Gender</label>
                    <select name="gender">
                        <?php
                        $gender_query="SELECT * FROM gender";
                        $gender_result=$conn->query($gender_query);
                        while ($row = $gender_result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row['gender_id']; ?>"><?php echo $row['gender']; ?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <label>Password</label>
                    <input type="password" name="password" required>

                    <label>Confirm Password</label>
                    <input type="password" name="confirmPassword" required>

                    <button class="button1" type="submit">Register</button>
                    <label for="loginBtn" style="margin-top: 10px;color:red;font-weight:100">Already have an Account?</label>
                    <button type="button" id="loginBtn" class="button2">Login</button>

                </form>

            </div>

        </div>

    </main>

    <?php include 'partials/footer.php'; ?>

</body>

</html>