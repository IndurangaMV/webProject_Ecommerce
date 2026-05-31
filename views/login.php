<?php
include "../config/session.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="../assests/css/login.css">
    <script src="../assests/js/login.js"defer></script>
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

            <form action="../config/register.php" method="post">  

                <label>Full Name</label>
                <input type="text" name="fullname" required>

                <label>Username</label>
                <input type="text" name="username" required>

                <label>Email</label>
                <input type="email" name="email" required>

                <label>Contact Number</label>
                <input type="tel" name="contact" required>

                <label>Gender</label>
                <select name="gender">
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>

                <label>Password</label>
                <input type="password" name="password" required>

                <label>Confirm Password</label>
                <input type="password" name="confirmPassword" required>

                <label>User Type</label>
                <select name="userType">
                    <option value="seller">Seller</option>
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>

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