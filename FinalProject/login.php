<?php
// login.php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $db->prepare("SELECT USER_ID, FIRST_NAME, PASSWORD FROM USER WHERE EMAIL = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['PASSWORD'])) {
                // Authentication success
                $_SESSION['user_id'] = $row['USER_ID'];
                $_SESSION['user_first_name'] = $row['FIRST_NAME'];
                header("Location: landing_page.php");
                exit();
            } else {
                // Password doesn't match
                $error = "Invalid email or password.";
            }
        } else {
            // Email not found or multiple matches (shouldn't happen)
            $error = "Invalid email or password.";
        }
        $stmt->close();
    } else {
        // SQL prepare failed (could be a syntax or connection issue)
        $error = "Server error. Please try again later.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Log In - Petunia</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form {
            max-width: 300px;
            margin: auto;
            padding-top: 50px;
        }
        label {
            display: block;
            margin-bottom: 6px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
        }
        input[type="submit"] {
            padding: 8px 16px;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Log In</h2>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        
        <input type="submit" value="Log In">
    </form>
</body>
</html>