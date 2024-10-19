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

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $bio = trim($_POST['bio']);

    if (empty($bio)) {
        die("Bio cannot be empty.");
    }

    // Update the profile's bio in the database
    $stmt = $pdo->prepare("UPDATE Profile SET bio = :bio WHERE profile_id = :id"); // Correct table name and primary key
    $stmt->execute([':bio' => $bio, ':id' => $_GET['id']]);

    // Redirect or provide success feedback
    echo "Profile bio updated successfully!";
}
?>

<!-- HTML form for editing the bio -->
<form method="POST">
    <label for="bio">Bio:</label><br>
    <textarea id="bio" name="bio" rows="4" cols="50"><?php echo htmlspecialchars($profile['bio']); ?></textarea><br>
    <input type="submit" value="Update Bio">
</form>
