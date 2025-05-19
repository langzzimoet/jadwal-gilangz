<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $nama = $conn->real_escape_string($_POST['nama']);

    if ($action == 'add') {
        $sql = "INSERT INTO ruangan (nama_ruangan) VALUES ('$nama')";
    } elseif ($action == 'edit') {
        $id = $conn->real_escape_string($_POST['id']);
        $sql = "UPDATE ruangan SET nama_ruangan = '$nama' WHERE id = '$id'";
    }

    if ($conn->query($sql)) {
        header("Location: index.php?success=" . ($action == 'add' ? 'ditambahkan' : 'diupdate'));
    } else {
        header("Location: " . ($action == 'add' ? 'add.php' : "edit.php?id=$id") . "?error=database");
    }
} else {
    header("Location: index.php");
}
?>