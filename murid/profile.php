<?php
include '../includes/auth_check.php';
include '../config/database.php';

if ($_SESSION['user']['role'] != 'murid') {
    header("Location: ../{$_SESSION['user']['role']}/dashboard.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['new_password'])) {
        if ($_POST['new_password'] != $_POST['confirm_password']) {
            $error = "Password baru tidak cocok!";
        } else {
            $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET password = '$password' WHERE id = '$user_id'");
            $success = "Password berhasil diubah!";
        }
    }
}

$murid = $conn->query("SELECT * FROM users WHERE id = '$user_id'")->fetch_assoc();
$kelas = $conn->query("SELECT nama_kelas FROM kelas WHERE id = '{$murid['kelas_id']}'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Murid - SMK Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <style>
        .profile-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .info-label {
            font-weight: 600;
            color: #495057;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="container px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Profil Saya</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card profile-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-circle"></i> Informasi Akun</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="info-label">NIS</div>
                            <div class="p-2 bg-light rounded"><?= htmlspecialchars($murid['username']) ?></div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="p-2 bg-light rounded"><?= htmlspecialchars($murid['nama']) ?></div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Kelas</div>
                            <div class="p-2 bg-light rounded"><?= htmlspecialchars($kelas['nama_kelas'] ?? '-') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card profile-card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Keamanan Akun</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle"></i> Simpan Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>