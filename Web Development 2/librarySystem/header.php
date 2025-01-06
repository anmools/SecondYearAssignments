<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div id="Header">
    <a href="index.php" class="back-to-home">
            <button class="back-button">Home</button>
        </a>
        <?php if (isset($_SESSION['user'])): ?>
            <form method="POST" action="logout.php">
                <button type="submit" class="logout-button">Logout</button>
            </form>
        <?php else: ?>
            <p><a href="login.php" style="color: #FFCB90; text-decoration: none;">Login</a> to access your account.</p>
        <?php endif; ?>
    </div>
</header>
