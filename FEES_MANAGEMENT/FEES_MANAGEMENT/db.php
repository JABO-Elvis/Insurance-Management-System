<?php
// ============================================================
// db.php — Connects to FinalExam2026 (for login)
// ============================================================
$host     = "localhost";
$user     = "root";
$password = "";

$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Auto-create database and table if they don't exist
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS FinalExam2026");
mysqli_select_db($conn, "FinalExam2026");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS Logger2026 (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
)");

// Insert default users only if table is empty
$check = mysqli_query($conn, "SELECT COUNT(*) as total FROM Logger2026");
$row   = mysqli_fetch_assoc($check);
if ($row['total'] == 0) {
    mysqli_query($conn, "INSERT INTO Logger2026 (username, password) VALUES ('admin', '1234')");
    mysqli_query($conn, "INSERT INTO Logger2026 (username, password) VALUES ('student', 'pass123')");
}
?>
