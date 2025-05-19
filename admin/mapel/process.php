<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $kode = $conn->real_escape_string($_POST['kode']);
    $nama = $conn->real_escape_string($_POST['nama']);

    if ($action == 'add') {
        $sql = "INSERT INTO mata_pelajaran (kode_mapel, nama_mapel) VALUES ('$kode', '$nama')";
    } elseif ($action == 'edit') {
        $id = $conn->real_escape_string($_POST['id']);
        $sql = "UPDATE mata_pelajaran SET kode_mapel = '$kode', nama_mapel = '$nama' WHERE id = '$id'";
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