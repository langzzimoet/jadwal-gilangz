<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $nis = $conn->real_escape_string($_POST['nis']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas_id = $conn->real_escape_string($_POST['kelas_id']);

    // Password default = NIS (bisa diganti murid nanti)
    $password = password_hash($nis, PASSWORD_DEFAULT);

    if ($action == 'add') {
        // Cek apakah NIS sudah ada
        $check = $conn->query("SELECT id FROM users WHERE username = '$nis'");
        if ($check->num_rows > 0) {
            header("Location: add.php?error=nis_sudah_ada");
            exit();
        }

        // Tambahkan murid baru
        $sql = "INSERT INTO users (username, password, nama, role, kelas_id) 
                VALUES ('$nis', '$password', '$nama', 'murid', '$kelas_id')";

        if ($conn->query($sql)) {
            header("Location: index.php?success=ditambahkan");
        } else {
            header("Location: add.php?error=database");
        }
    } 
    elseif ($action == 'edit') {
        $id = $conn->real_escape_string($_POST['id']);
        $sql = "UPDATE users SET 
                username = '$nis',
                nama = '$nama',
                kelas_id = '$kelas_id'
                WHERE id = '$id' AND role = 'murid'";

        if ($conn->query($sql)) {
            header("Location: index.php?success=diupdate");
        } else {
            header("Location: edit.php?id=$id&error=database");
        }
    }
} else {
    header("Location: index.php");
}
?>