<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $kelas_id = $conn->real_escape_string($_POST['kelas_id']);
    $mapel_id = $conn->real_escape_string($_POST['mapel_id']);
    $guru_id = $conn->real_escape_string($_POST['guru_id']);
    $ruangan_id = $conn->real_escape_string($_POST['ruangan_id']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);
    $jam_ke = $conn->real_escape_string($_POST['jam_ke']);
    $sampai_jam_ke = $conn->real_escape_string($_POST['sampai_jam_ke']);
    $jam_mulai = $conn->real_escape_string($_POST['jam_mulai']);
    $jam_selesai = $conn->real_escape_string($_POST['jam_selesai']);
    $hari = $conn->real_escape_string($_POST['hari']);
    $semester = 1; // Default semester
    $tahun_ajaran = date('Y') . '/' . (date('Y') + 1); // Default tahun ajaran

    if ($action == 'add') {
        // Check for schedule conflict
        $conflict_check = $conn->query("
            SELECT id FROM jadwal 
            WHERE ruangan_id = '$ruangan_id' 
            AND tanggal = '$tanggal' 
            AND hari = '$hari'
            AND (
                (jam_mulai <= '$jam_mulai' AND jam_selesai > '$jam_mulai') OR
                (jam_mulai < '$jam_selesai' AND jam_selesai >= '$jam_selesai') OR
                (jam_mulai >= '$jam_mulai' AND jam_selesai <= '$jam_selesai')
            )
        ");

        if ($conflict_check->num_rows > 0) {
            header("Location: add.php?error=conflict");
            exit();
        }

        $sql = "INSERT INTO jadwal (
            kelas_id, mapel_id, guru_id, ruangan_id, tanggal, 
            jam_ke, sampai_jam_ke, jam_mulai, jam_selesai, 
            semester, tahun_ajaran, hari
        ) VALUES (
            '$kelas_id', '$mapel_id', '$guru_id', '$ruangan_id', '$tanggal', 
            '$jam_ke', '$sampai_jam_ke', '$jam_mulai', '$jam_selesai', 
            '$semester', '$tahun_ajaran', '$hari'
        )";
    } elseif ($action == 'edit') {
        $id = $conn->real_escape_string($_POST['id']);

        $sql = "UPDATE jadwal SET
            kelas_id = '$kelas_id',
            mapel_id = '$mapel_id',
            guru_id = '$guru_id',
            ruangan_id = '$ruangan_id',
            tanggal = '$tanggal',
            hari = '$hari',
            jam_ke = '$jam_ke',
            sampai_jam_ke = '$sampai_jam_ke',
            jam_mulai = '$jam_mulai',
            jam_selesai = '$jam_selesai'
            WHERE id = '$id'";
    }

    if ($conn->query($sql)) {
        $action_text = $action == 'add' ? 'ditambahkan' : 'diperbarui';
        header("Location: index.php?success=$action_text");
    } else {
        header("Location: index.php?error=database");
    }
} else {
    header("Location: index.php");
}
?>