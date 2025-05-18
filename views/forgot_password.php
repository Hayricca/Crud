<?php
session_start();
include "../koneksi.php"; // Koneksi MySQLi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if ($new_password !== $confirm_password) {
        echo "Password tidak cocok!";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Query untuk mengupdate password di database
        $query = "UPDATE login SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $hashed_password, $username);

        if ($stmt->execute()) {
            echo "Password berhasil diubah! <a href='login.php'>Login di sini</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="../styles/login.css">
</head>
<body>
    <div class="wrapper">
        <form action="" method="POST">
            <h2>Forgot Password</h2>
            <div class="input-field">
                <input type="text" name="username" required>
                <label>Enter your username</label>
            </div>
            <div class="input-field">
                <input type="password" name="new_password" required>
                <label>Enter new password</label>
            </div>
            <div class="input-field">
                <input type="password" name="confirm_password" required>
                <label>Confirm new password</label>
            </div>
            <button type="submit">Reset Password</button>
            <div class="login">
                <p>Remembered your password? <a href="login.php">Log In</a></p>
            </div>
        </form>
    </div>
</body>
</html>