<?php
session_start();
require 'config.php';

try {
    // Fetch all profiles
    $stmt = $pdo->query("SELECT * FROM Profile"); // Ensure correct table name
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Handle any errors
    die("Error fetching profiles: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profiles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        a {
            margin-right: 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
    </style>
</head>
<body>
    <h1>Profiles</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="add.php">Add Profile</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>

    <ul>
        <?php foreach ($profiles as $profile): ?>
            <li>
                <a href="view.php?id=<?= htmlentities($profile['profile_id']) ?>"><?= htmlentities($profile['headline']) ?></a> <!-- Assuming 'headline' is what you want to display -->
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $profile['user_id']): ?>
                    <a href="edit.php?id=<?= htmlentities($profile['profile_id']) ?>">Edit</a>
                    <a href="delete.php?id=<?= htmlentities($profile['profile_id']) ?>">Delete</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
