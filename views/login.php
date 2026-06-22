<?php
include "../config/session.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="../sample/style2.css">
</head>

<body>

<h1>Login</h1>

<form action="../config/auth.php" method="post">

    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>

</form>

</body>
</html>