<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "presensi";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
?>
