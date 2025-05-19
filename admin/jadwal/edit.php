<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../includes/auth_check.php';
include '../../config/database.php';


// Check if ID parameter exists
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit();
}

$id = $conn->real_escape_string($_GET['id']);

// Get the existing jadwal data
$jadwal_query = "SELECT * FROM jadwal WHERE id = '$id'";
$jadwal_result = $conn->query($jadwal_query);

if (!$jadwal_result || $jadwal_result->num_rows == 0) {
    header("Location: index.php?error=not_found");
    exit();
}

$jadwal = $jadwal_result->fetch_assoc();

// Get data for dropdowns
$kelas = $conn->query("SELECT * FROM kelas ORDER BY nama_kelas");
$mapel = $conn->query("SELECT * FROM mata_pelajaran ORDER BY nama_mapel");
$guru = $conn->query("SELECT * FROM users WHERE role = 'guru' ORDER BY nama");
$ruangan = $conn->query("SELECT * FROM ruangan ORDER BY nama_ruangan");

// Check for query errors
$queries = ['kelas' => $kelas, 'mapel' => $mapel, 'guru' => $guru, 'ruangan' => $ruangan];
foreach ($queries as $name => $query) {
    if (!$query) {
        die("Error in $name query: " . $conn->error);
    }
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
            <h1 class="h2">Edit Jadwal</h1>
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?php
                $errors = [
                    'invalid_id' => 'ID jadwal tidak valid',
                    'not_found' => 'Data jadwal tidak ditemukan',
                    'database' => 'Terjadi kesalahan database'
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
                    <input type="hidden" name="id" value="<?php echo $jadwal['id']; ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="kelas_id" class="form-label required-field">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                <?php while ($row = $kelas->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo ($jadwal['kelas_id'] == $row['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($row['nama_kelas']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="mapel_id" class="form-label required-field">Mata Pelajaran</label>
                            <select class="form-select" id="mapel_id" name="mapel_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php while ($row = $mapel->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo ($jadwal['mapel_id'] == $row['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($row['nama_mapel']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="guru_id" class="form-label required-field">Guru</label>
                            <select class="form-select" id="guru_id" name="guru_id" required>
                                <option value="">Pilih Guru</option>
                                <?php while ($row = $guru->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo ($jadwal['guru_id'] == $row['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($row['nama']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="ruangan_id" class="form-label required-field">Ruangan</label>
                            <select class="form-select" id="ruangan_id" name="ruangan_id" required>
                                <option value="">Pilih Ruangan</option>
                                <?php while ($row = $ruangan->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo ($jadwal['ruangan_id'] == $row['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($row['nama_ruangan']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal" class="form-label required-field">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="<?php echo htmlspecialchars($jadwal['tanggal']); ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label for="jam_ke" class="form-label required-field">Jam Ke</label>
                            <input type="number" class="form-control" id="jam_ke" name="jam_ke" min="1" max="12"
                                value="<?php echo htmlspecialchars($jadwal['jam_ke']); ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label for="sampai_jam_ke" class="form-label required-field">Sampai Jam Ke</label>
                            <input type="number" class="form-control" id="sampai_jam_ke" name="sampai_jam_ke" min="1"
                                max="12" value="<?php echo htmlspecialchars($jadwal['sampai_jam_ke']); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jam_mulai" class="form-label required-field">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai"
                                value="<?php echo date('H:i', strtotime($jadwal['jam_mulai'])); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jam_selesai" class="form-label required-field">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai"
                                value="<?php echo date('H:i', strtotime($jadwal['jam_selesai'])); ?>" required>
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
        // Client-side validation
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');

            // Validate jam ke
            document.getElementById('sampai_jam_ke').addEventListener('change', function () {
                const jamKe = parseInt(document.getElementById('jam_ke').value);
                const sampaiJamKe = parseInt(this.value);

                if (sampaiJamKe < jamKe) {
                    alert('Sampai Jam Ke tidak boleh kurang dari Jam Ke');
                    this.value = jamKe;
                }
            });

            // Validate time range
            document.getElementById('jam_selesai').addEventListener('change', function () {
                const jamMulai = document.getElementById('jam_mulai').value;
                const jamSelesai = this.value;

                if (jamSelesai <= jamMulai) {
                    alert('Jam Selesai harus setelah Jam Mulai');
                    this.value = '';
                }
            });

            // Form submission validation
            form.addEventListener('submit', function (e) {
                let valid = true;

                // Check all required fields
                document.querySelectorAll('[required]').forEach(function (field) {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        valid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Harap isi semua bidang yang wajib diisi!');
                }
            });
        });
    </script>
</body>

</html>