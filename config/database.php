<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'jadwal_gilang';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$base_url = 'http://localhost/jadwal_gilangbaru/jadwal_gilang/';
?>