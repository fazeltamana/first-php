<?php
// Database connection details
$dsn = 'mysql:host=localhost;dbname=my_project'; // Ensure this matches your intended database
$user = 'newuser';
$password = 'newpassword';

try {
    $pdo = new PDO($dsn, $user, $password);
    echo "Connection successful!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
