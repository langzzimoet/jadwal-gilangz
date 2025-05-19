<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

// Get data for dropdowns
$kelas = $conn->query("SELECT * FROM kelas ORDER BY nama_kelas");
$mapel = $conn->query("SELECT * FROM mata_pelajaran ORDER BY nama_mapel");
$guru = $conn->query("SELECT * FROM users WHERE role = 'guru' ORDER BY nama");
$ruangan = $conn->query("SELECT * FROM ruangan ORDER BY nama_ruangan");

$title = "Tambah Jadwal";
$action = "add";
$jadwal = null;

// For edit mode
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $result = $conn->query("SELECT * FROM jadwal WHERE id = $id");
    
    if ($result->num_rows == 1) {
        $jadwal = $result->fetch_assoc();
        $title = "Edit Jadwal";
        $action = "edit";
    } else {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - SMK Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="../../../assets/css/style.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php include_once '../header_admin.php'; ?>
    <main class="container px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"><?php echo $title; ?></h1>
            <a href="index.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="process.php" method="POST" class="form-container">
                    <input type="hidden" name="action" value="<?php echo $action; ?>">
                    <?php if ($action == 'edit'): ?>
                        <input type="hidden" name="id" value="<?php echo $jadwal['id']; ?>">
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                <?php while ($row = $kelas->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" 
                                        <?php if ($action == 'edit' && $jadwal['kelas_id'] == $row['id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($row['nama_kelas']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mapel_id" name="mapel_id" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php while ($row = $mapel->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" 
                                        <?php if ($action == 'edit' && $jadwal['mapel_id'] == $row['id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($row['nama_mapel']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="guru_id" class="form-label">Guru</label>
                            <select class="form-select" id="guru_id" name="guru_id" required>
                                <option value="">Pilih Guru</option>
                                <?php while ($row = $guru->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" 
                                        <?php if ($action == 'edit' && $jadwal['guru_id'] == $row['id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($row['nama']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="ruangan_id" class="form-label">Ruangan</label>
                            <select class="form-select" id="ruangan_id" name="ruangan_id" required>
                                <option value="">Pilih Ruangan</option>
                                <?php while ($row = $ruangan->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>" 
                                        <?php if ($action == 'edit' && $jadwal['ruangan_id'] == $row['id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($row['nama_ruangan']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                value="<?php echo $action == 'edit' ? $jadwal['tanggal'] : ''; ?>" required>
                            <input type="text" class="form-control" id="hari" name="hari" hidden
                                value="<?php echo $action == 'edit' ? $jadwal['hari'] : ''; ?>">
                        </div>

                        <div class="col-md-3">
                            <label for="jam_ke" class="form-label">Jam Ke</label>
                            <input type="number" class="form-control" id="jam_ke" name="jam_ke" min="1" max="12"
                                value="<?php echo $action == 'edit' ? $jadwal['jam_ke'] : ''; ?>" required>
                        </div>

                        <div class="col-md-3">
                            <label for="sampai_jam_ke" class="form-label">Sampai Jam Ke</label>
                            <input type="number" class="form-control" id="sampai_jam_ke" name="sampai_jam_ke" min="1" max="12"
                                value="<?php echo $action == 'edit' ? $jadwal['sampai_jam_ke'] : ''; ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai"
                                value="<?php echo $action == 'edit' ? date('H:i', strtotime($jadwal['jam_mulai'])) : ''; ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai"
                                value="<?php echo $action == 'edit' ? date('H:i', strtotime($jadwal['jam_selesai'])) : ''; ?>" required>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
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
        // Simple validation to ensure sampai_jam_ke >= jam_ke
        document.getElementById('sampai_jam_ke').addEventListener('change', function() {
            const jamKe = parseInt(document.getElementById('jam_ke').value);
            const sampaiJamKe = parseInt(this.value);
            
            if (sampaiJamKe < jamKe) {
                alert('Sampai Jam Ke tidak boleh kurang dari Jam Ke');
                this.value = jamKe;
            }
        });
        

        document.getElementById('tanggal').addEventListener('change', function() {
                const date = new Date(this.value);
                // Get day of week (0-6, where 0 is Sunday)
                let day = date.getDay();
                // Convert to 1-7 where 1 is Monday
                day = day === 0 ? 7 : day;
                document.getElementById('hari').value = day;
            });

    </script>
</body>
</html>