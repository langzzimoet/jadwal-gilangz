<?php
include '../includes/auth_check.php';
include '../config/database.php';

$kelas_id = $_SESSION['user']['kelas_id'];

if (!$kelas_id) {
    die("Anda belum terdaftar di kelas manapun.");
}

// Jadwal hari ini
$hari_ini = date('N'); // Karena database menggunakan 0-4 (Senin-Jumat)
$jadwal_hari_ini = $conn->query("
    SELECT j.*, m.nama_mapel, u.nama as nama_guru, r.nama_ruangan
    FROM jadwal j
    JOIN mata_pelajaran m ON j.mapel_id = m.id
    JOIN users u ON j.guru_id = u.id
    JOIN ruangan r ON j.ruangan_id = r.id
    WHERE j.kelas_id = $kelas_id AND j.hari = $hari_ini
    ORDER BY j.jam_mulai
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Murid Dashboard - Jadwalin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <!-- <?php include '../includes/sidebar.php'; ?> -->

    <main class="container px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard Murid</h1>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Jadwal Pelajaran Hari Ini</h5>
            </div>
            <div class="card-body">
                <?php if ($jadwal_hari_ini->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $jadwal_hari_ini->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('H:i', strtotime($row['jam_mulai'])) . ' - ' . date('H:i', strtotime($row['jam_selesai'])); ?></td>
                                        <td><?php echo $row['nama_mapel']; ?></td>
                                        <td><?php echo $row['nama_guru']; ?></td>
                                        <td><?php echo $row['nama_ruangan']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Tidak ada jadwal pelajaran untuk hari ini.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/script.js"></script>
</body>
</html>