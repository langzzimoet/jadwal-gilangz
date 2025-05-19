<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

// Get student data
$murid = $conn->query("SELECT * FROM users WHERE id = '$id' AND role = 'murid'");
if (!$murid || $murid->num_rows == 0) {
    header("Location: index.php?error=not_found");
    exit();
}
$murid = $murid->fetch_assoc();

// Get class data for dropdown
$kelas = $conn->query("SELECT * FROM kelas ORDER BY nama_kelas");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Murid - SMK Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="../../../assets/css/style.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .required-field::after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body>
    <?php include_once '../header_admin.php'; ?>

    <main class="container px-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Data Murid</h1>
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php
                $errors = [
                    'database' => 'Terjadi kesalahan database',
                    'not_found' => 'Data murid tidak ditemukan'
                ];
                echo $errors[$_GET['error']] ?? 'Terjadi kesalahan';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="process.php" method="POST" class="form-container">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $murid['id'] ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nis" class="form-label required-field">NIS/NISN</label>
                            <input type="text" class="form-control" id="nis" name="nis"
                                value="<?= htmlspecialchars($murid['username']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="kelas_id" class="form-label required-field">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                <?php while ($row = $kelas->fetch_assoc()): ?>
                                    <option value="<?= $row['id'] ?>" <?= ($row['id'] == $murid['kelas_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['nama_kelas']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="nama" class="form-label required-field">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="<?= htmlspecialchars($murid['nama']) ?>" required>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                            <a href="index.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function (e) {
            const nis = document.getElementById('nis').value.trim();
            const nama = document.getElementById('nama').value.trim();
            const kelas = document.getElementById('kelas_id').value;

            if (!nis || !nama || !kelas) {
                e.preventDefault();
                alert('Harap isi semua field yang wajib diisi!');
            }
        });
    </script>
</body>

</html>