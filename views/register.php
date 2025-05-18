<?php
session_start();
include_once("koneksi.php"); // Koneksi MySQLi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = isset($_POST['role']) ? $_POST['role'] : null;

    // Validasi input
    if (!$role) {
        echo "Role belum dipilih!";
    } elseif ($password !== $confirm_password) {
        echo "Password tidak cocok!";
    } elseif (!in_array($role, ['user', 'admin'])) {
        echo "Role tidak valid!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Query untuk menyimpan data ke database
        $query = "INSERT INTO login (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
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
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../styles/login.css">
</head>
<body>
    <div class="wrapper">
        <form action="" method="POST">
            <h2>Register</h2>
            <div class="input-field">
                <input type="text" name="username" required>
                <label>Enter your username</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter your password</label>
            </div>
            <div class="input-field">
                <input type="password" name="confirm_password" required>
                <label>Confirm your password</label>
            </div>
            <div class="input-field">
                <label>Select role:</label>
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit">Register</button>
            <div class="login">
                <p>Already have an account? <a href="login.php">Log In</a></p>
            </div>
        </form>
    </div>
</body>
</html>