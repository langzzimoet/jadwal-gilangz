<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

$ruangan = $conn->query("SELECT * FROM ruangan WHERE id = '$id'");
if (!$ruangan || $ruangan->num_rows == 0) {
    header("Location: index.php?error=not_found");
    exit();
}
$ruangan = $ruangan->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal - SMK Jadwal</title>
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
            <h1 class="h2">Edit Ruangan</h1>
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="process.php" method="POST" class="form-container">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $ruangan['id']; ?>">

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nama" class="form-label required-field">Nama Ruangan</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="<?= htmlspecialchars($ruangan['nama_ruangan']); ?>" required>
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
</body>

</html>