<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

// Check if an ID is provided
if (!isset($_GET['id'])) {
    die("No profile specified.");
}

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :id"); // Correct table name and primary key
$stmt->execute([':id' => $_GET['id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the profile exists and if the user has access
if (!$profile || $profile['user_id'] !== $_SESSION['user_id']) {
    die("Access denied.");
}

// Process the deletion on POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("DELETE FROM Profile WHERE profile_id = :id"); // Correct table name and primary key
    $stmt->execute([':id' => $_GET['id']]);
    header('Location: index.php'); // Redirect to the profile list after deletion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Profile</title>
</head>
<body>
    <h1>Delete Profile</h1>
    <p>Are you sure you want to delete the profile titled: <strong><?= htmlentities($profile['headline']) ?></strong>?</p> <!-- Display profile title -->
    <form method="POST">
        <input type="submit" value="Yes, delete it">
    </form>
    <a href="index.php">Cancel</a>
</body>
</html>
