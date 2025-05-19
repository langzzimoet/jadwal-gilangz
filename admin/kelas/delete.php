<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

// First check if the class is used in jadwal
$check = $conn->query("SELECT id FROM jadwal WHERE kelas_id = '$id' LIMIT 1");
if ($check->num_rows > 0) {
    header("Location: index.php?error=in_use");
    exit();
}

// Delete the class
$sql = "DELETE FROM kelas WHERE id = '$id'";

if ($conn->query($sql)) {
    header("Location: index.php?success=dihapus");
} else {
    header("Location: index.php?error=database");
}
?>