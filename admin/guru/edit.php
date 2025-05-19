<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

// Get teacher data
$guru = $conn->query("SELECT * FROM users WHERE id = '$id' AND role = 'guru'");
if (!$guru || $guru->num_rows == 0) {
    header("Location: index.php?error=not_found");
    exit();
}
$guru = $guru->fetch_assoc();

// Get all subjects
$mapel = $conn->query("SELECT * FROM mata_pelajaran ORDER BY nama_mapel");

// Get teacher's current subjects
$guru_mapel = $conn->query("SELECT mapel_id FROM guru_mapel WHERE guru_id = '$id'");
$selected_mapel = [];
while ($row = $guru_mapel->fetch_assoc()) {
    $selected_mapel[] = $row['mapel_id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
            <h1 class="h2">Edit Guru</h1>
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="process.php" method="POST" class="form-container">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?= $guru['id']; ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label required-field">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?= htmlspecialchars($guru['username']); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        <div class="col-12">
                            <label for="nama" class="form-label required-field">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="<?= htmlspecialchars($guru['nama']); ?>" required>
                        </div>

                        <div class="col-12">
                            <label for="mapel_ids" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mapel_ids" name="mapel_ids[]" multiple size="5">
                                <?php while ($row = $mapel->fetch_assoc()): ?>
                                    <option value="<?= $row['id']; ?>" <?= in_array($row['id'], $selected_mapel) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['nama_mapel']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <small class="text-muted">Gunakan Ctrl+Click untuk memilih banyak</small>
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