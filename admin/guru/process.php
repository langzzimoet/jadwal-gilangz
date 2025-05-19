<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $nama = $conn->real_escape_string($_POST['nama']);
    $username = $conn->real_escape_string($_POST['username']);
    $mapel_ids = $_POST['mapel_ids'] ?? [];

    if ($action == 'add') {
        // Handle password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Insert user
        $sql = "INSERT INTO users (username, password, nama, role) 
                VALUES ('$username', '$password', '$nama', 'guru')";
        
        if ($conn->query($sql)) {
            $guru_id = $conn->insert_id;
            
            // Insert guru-mapel relationships
            foreach ($mapel_ids as $mapel_id) {
                $mapel_id = $conn->real_escape_string($mapel_id);
                $conn->query("INSERT INTO guru_mapel (guru_id, mapel_id) VALUES ('$guru_id', '$mapel_id')");
            }
            
            header("Location: index.php?success=ditambahkan");
        } else {
            header("Location: add.php?error=database");
        }
    } elseif ($action == 'edit') {
        $id = $conn->real_escape_string($_POST['id']);
        
        // Build update query
        $sql = "UPDATE users SET nama = '$nama', username = '$username'";
        
        // Update password if provided
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql .= ", password = '$password'";
        }
        
        $sql .= " WHERE id = '$id'";
        
        if ($conn->query($sql)) {
            // Update guru-mapel relationships
            $conn->query("DELETE FROM guru_mapel WHERE guru_id = '$id'");
            foreach ($mapel_ids as $mapel_id) {
                $mapel_id = $conn->real_escape_string($mapel_id);
                $conn->query("INSERT INTO guru_mapel (guru_id, mapel_id) VALUES ('$id', '$mapel_id')");
            }
            
            header("Location: index.php?success=diupdate");
        } else {
            header("Location: edit.php?id=$id&error=database");
        }
    }
} else {
    header("Location: index.php");
}
?>