<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

// Ambil NIS murid
$murid = $conn->query("SELECT username FROM users WHERE id = '$id' AND role = 'murid'");
if ($murid->num_rows == 0) {
    header("Location: index.php?error=murid_tidak_ditemukan");
    exit();
}

$nis = $murid->fetch_assoc()['username'];
$new_password = password_hash($nis, PASSWORD_DEFAULT);

// Update password
$conn->query("UPDATE users SET password = '$new_password' WHERE id = '$id'");

header("Location: index.php?success=password_direset");
?> 