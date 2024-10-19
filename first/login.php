<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Prepare and execute the SQL statement to fetch the user
    $stmt = $pdo->prepare('SELECT user_id, name, password FROM users WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and verify the password
    if ($row) {
        if (password_verify($password, $row['password'])) {
            // Password matches, log in the user
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            session_regenerate_id(true); // Regenerate session ID to prevent session fixation attacks
            header("Location: index.php"); // Redirect to homepage
            exit();
        } else {
            // Password is incorrect
            $_SESSION['flash_message'] = "Invalid login credentials.";
        }
    } else {
        // No user found with the entered email
        $_SESSION['flash_message'] = "Invalid login credentials.";
    }

    header("Location: login.php"); // Redirect back to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script>
        function doValidate() {
            const email = document.getElementById('email').value;
            const pw = document.getElementById('password').value;

            if (!email || !pw) {
                alert("Both fields must be filled out");
                return false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Invalid email format");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" onsubmit="return doValidate();">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Log In">
    </form>

    <?php if (isset($_SESSION['flash_message'])): ?>
        <p style="color:red;"><?= htmlentities($_SESSION['flash_message']) ?></p>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
</body>
</html>
