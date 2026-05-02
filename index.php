<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['user'];

// get user id safely
$getUser = $conn->query("SELECT id FROM users WHERE username='$username'");
$userData = $getUser->fetch_assoc();

if (!$userData) {
    echo "User not found!";
    exit();
}

$user_id = $userData['id'];

// get tasks (NEW: sorted by latest)
$result = $conn->query("SELECT * FROM tasks WHERE user_id=$user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>TaskFlow Pro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- TOP BAR -->
    <div class="topbar">
        <div>
            <h1>TaskFlow</h1>

            <?php
            if (isset($_SESSION['welcome_text'])) {
                echo "<p>{$_SESSION['welcome_text']} " . htmlspecialchars($username) . "</p>";
                unset($_SESSION['welcome_text']);
            } else {
                echo "<p>Welcome back 👋 " . htmlspecialchars($username) . "</p>";
            }
            ?>
        </div>

        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- ADD TASK -->
    <div class="card">
        <form action="add.php" method="POST" class="task-form">
            <input type="text" name="task" placeholder="Write a new task..." required>
            <button>Add</button>
        </form>
    </div>

    <!-- TASK GRID -->
    <div class="grid">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()) { ?>
                
                <div class="task-card">

                    <!-- TASK NAME -->
                    <div class="task-title">
                        <?php echo htmlspecialchars($row['task_name']); ?>
                    </div>

                    <!-- DATE & TIME -->
                    <div class="task-date">
                        <?php echo date("d M Y, h:i A", strtotime($row['created_at'])); ?>
                    </div>

                    <!-- STATUS + ACTIONS -->
                    <div class="task-bottom">
                        <span class="status">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </span>

                        <div class="actions">
                            <a href="update.php?id=<?php echo $row['id']; ?>">✔</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" 
                               onclick="return confirm('Delete this task?')">🗑</a>
                        </div>
                    </div>

                </div>

            <?php } ?>

        <?php else: ?>

            <!-- EMPTY STATE -->
            <div class="card" style="text-align:center;">
                <p>No tasks yet 👀</p>
                <small>Add your first task above</small>
            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>