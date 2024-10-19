<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $bio = trim($_POST['bio']);

    if (empty($bio)) {
        die("Bio cannot be empty.");
    }

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare('INSERT INTO Profile (user_id, bio) VALUES (:uid, :bio)'); // Correct table name
    $stmt->execute([
        ':uid' => $_SESSION['user_id'],
        ':bio' => $bio
    ]);
    header('Location: index.php'); // Redirect after adding the profile
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Profile</title>
</head>
<body>
    <h1>Add Profile</h1>
    <form method="POST">
        <label for="bio">Bio:</label>
        <textarea name="bio" required></textarea>
        <input type="submit" value="Add">
    </form>
    <a href="index.php">Cancel</a> <!-- Link to return without saving -->
</body>
</html>
