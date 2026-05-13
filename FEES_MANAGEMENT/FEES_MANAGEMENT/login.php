<?php
// ===== START SESSION =====
session_start();

// ===== INCLUDE DATABASE CONNECTION =====
require 'db.php';

// ===== INITIALIZE ERROR VARIABLE =====
$error = "";

// ===== HANDLE FORM SUBMISSION =====
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LOGIN BUTTON clicked ---
    if (isset($_POST['login'])) {

        // Get values from the form and clean them
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Check if user exists in Logger2026 table
        $sql    = "SELECT * FROM Logger2026 WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            // Login SUCCESS → save username in session → go to index.php
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            // Login FAILED → show error
            $error = "Invalid username or password. Please try again.";
        }
    }

    // --- EXIT BUTTON clicked ---
    if (isset($_POST['exit'])) {
        echo "<script>window.close();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Login Form</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="login.css">
</head>
<body>

<!-- The form sends data to this same file (login.php) using POST -->
<form method="POST" action="login.php">

    <div class="login-wrapper">

        <!-- Title Bar -->
        <div class="login-title">STUDENTS LOGIN FORM</div>

        <!-- Show error message if login failed -->
        <?php if ($error != ""): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Username Field -->
        <div class="form-row">
            <label>USER-NAME:</label>
            <input type="text" name="username" required autofocus>
        </div>

        <!-- Password Field -->
        <div class="form-row">
            <label>PASSWORD:</label>
            <input type="password" name="password" required>
        </div>

        <!-- LOGIN and EXIT Buttons -->
        <div class="btn-row">
            <input type="submit" name="login" value="LOGIN">
            <input type="submit" name="exit"  value="EXIT">
        </div>

    </div>

</form>

</body>
</html>
