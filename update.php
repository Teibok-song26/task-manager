<?php
include 'db.php';

$id = $_GET['id'];

$conn->query("UPDATE tasks SET status='completed' WHERE id=$id");

header("Location: index.php");
?>