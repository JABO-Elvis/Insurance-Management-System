<?php
// ============================================================
// db2.php — Connects to DBGroupA2026 (for fees data)
// ============================================================
$host     = "localhost";
$user     = "root";
$password = "";

$conn2 = mysqli_connect($host, $user, $password);

if (!$conn2) {
    die("Connection failed: " . mysqli_connect_error());
}

// Auto-create database and table if they don't exist
mysqli_query($conn2, "CREATE DATABASE IF NOT EXISTS DBGroupA2026");
mysqli_select_db($conn2, "DBGroupA2026");

mysqli_query($conn2, "CREATE TABLE IF NOT EXISTS Fees2026 (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    student_name      VARCHAR(150) NOT NULL,
    student_id        VARCHAR(50)  NOT NULL,
    academic_year     VARCHAR(20),
    no_of_courses     INT,
    total_credits     INT,
    amount_per_credit DECIMAL(10,2),
    registration_fees DECIMAL(10,2),
    final_project     DECIMAL(10,2),
    graduation_fees   DECIMAL(10,2),
    total_fees        DECIMAL(10,2)
)");
?>
