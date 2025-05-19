<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

// First delete from guru_mapel
$conn->query("DELETE FROM guru_mapel WHERE mapel_id = '$id'");

// Then delete from mata_pelajaran
$sql = "DELETE FROM mata_pelajaran WHERE id = '$id'";

if ($conn->query($sql)) {
    header("Location: index.php?success=dihapus");
} else {
    header("Location: index.php?error=database");
}
?>