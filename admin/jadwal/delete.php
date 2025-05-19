<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "DELETE FROM jadwal WHERE id = '$id'";
    
    if ($conn->query($sql)) {
        header("Location: index.php?success=dihapus");
    } else {
        header("Location: index.php?error=database");
    }
} else {
    header("Location: index.php");
}
?>