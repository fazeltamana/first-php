<?php
session_start();
require 'config.php';

// Ensure an ID is provided in the query string
if (!isset($_GET['id'])) {
    die("No profile specified.");
}

// Prepare and execute the SQL statement to fetch the profile
$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :id"); // Use correct table name and primary key
$stmt->execute([':id' => $_GET['id']]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the profile exists
if (!$profile) {
    die("Profile not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Profile</title>
</head>
<body>
    <h1>Profile Details</h1>
    <p><strong>Bio:</strong> <?= htmlentities($profile['bio']) ?></p>
    <p><strong>Owner:</strong> <?= htmlentities($profile['user_id']) ?></p> <!-- Display the user ID or name if you have it -->
    <a href="index.php">Back to Profiles</a>
</body>
</html>
