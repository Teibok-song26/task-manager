<?php
include 'db.php';

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')");

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Register</h2>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Sign Up</button>
        </form>

        <p class="link">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </div>
</div>

</body>
</html>