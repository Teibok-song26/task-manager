<?php
session_start();
include 'db.php';

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // get user
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user['username'];

        // FIX: safe check for first login
        if (empty($user['last_login'])) {
            $_SESSION['welcome_text'] = "Welcome 👋";
        } else {
            $_SESSION['welcome_text'] = "Welcome back 👋";
        }

        // update last login time
        $conn->query("UPDATE users SET last_login = NOW() WHERE id = {$user['id']}");

        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>

<div class="container">
    <div class="card">

        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <p class="link">
            Don’t have an account? <a href="register.php">Register</a>
        </p>

    </div>
</div>

</body>
</html>