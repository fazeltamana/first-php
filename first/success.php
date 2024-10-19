<?php
session_start();
require 'config.php';
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// User is logged in, proceed to display the page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #4CAF50; /* A welcoming green color */
        }
        p {
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?= htmlentities($_SESSION['name']) ?>!</h1>
    <p>You are successfully logged in.</p>

    <a href="index.php">Go to Profiles</a> <!-- Link to navigate to profiles -->
    <br>
    <a href="logout.php">Log Out</a> <!-- Link to log out -->
</body>
</html>
