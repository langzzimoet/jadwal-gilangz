<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$current_role = $_SESSION['user']['role'];
$allowed_roles = ['admin', 'guru', 'murid'];

if (!in_array($current_role, $allowed_roles)) {
    header("Location: ../../auth/login.php");
    exit();
}

// Check if user is trying to access a page not for their role
$request_uri = $_SERVER['REQUEST_URI'];
$role_path = "/$current_role/";

if (strpos($request_uri, $role_path) === false && strpos($request_uri, '/auth/') === false) {
    header("Location: ../$current_role/dashboard.php");
    exit();
}
?>