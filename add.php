<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$task = trim($_POST['task']);
$user = $_SESSION['user'];

if (empty($task)) {
    header("Location: index.php");
    exit();
}

// get user id
$getUser = $conn->query("SELECT id FROM users WHERE username='$user'");
$userData = $getUser->fetch_assoc();
$user_id = $userData['id'];

// insert task (time auto added)
$conn->query("INSERT INTO tasks (task_name, user_id) VALUES ('$task', $user_id)");

header("Location: index.php");
exit();
?>