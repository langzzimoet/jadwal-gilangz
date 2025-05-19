<?php
include '../includes/auth_check.php';
include '../config/database.php';

$guru_id = $_SESSION['user']['id'];

// Count jadwal mengajar
$count_jadwal = $conn->query("SELECT COUNT(*) FROM jadwal WHERE guru_id = $guru_id")->fetch_row()[0];

// Jadwal hari ini
$hari_ini = date('N') ; // Karena database menggunakan 0-4 (Senin-Jumat)
$jadwal_hari_ini = $conn->query("
    SELECT j.*, m.nama_mapel, k.nama_kelas, r.nama_ruangan
    FROM jadwal j
    JOIN mata_pelajaran m ON j.mapel_id = m.id
    JOIN kelas k ON j.kelas_id = k.id
    JOIN ruangan r ON j.ruangan_id = r.id
    WHERE j.guru_id = $guru_id AND j.hari = $hari_ini
    ORDER BY j.jam_mulai
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru Dashboard - SMK Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="container px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard Guru</h1>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Jadwal Mengajar</h5>
                        <p class="card-text display-6"><?php echo $count_jadwal; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Jadwal Mengajar Hari Ini</h5>
            </div>
            <div class="card-body">
                <?php if ($jadwal_hari_ini->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $jadwal_hari_ini->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo date('H:i', strtotime($row['jam_mulai'])) . ' - ' . date('H:i', strtotime($row['jam_selesai'])); ?></td>
                                        <td><?php echo $row['nama_mapel']; ?></td>
                                        <td><?php echo $row['nama_kelas']; ?></td>
                                        <td><?php echo $row['nama_ruangan']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Tidak ada jadwal mengajar untuk hari ini.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/script.js"></script>
</body>
</html>