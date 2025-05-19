<?php
include '../includes/auth_check.php';
include '../config/database.php';

$guru_id = $_SESSION['user']['id'];

// Get current day (1-7, where 1=Monday)
$hari_ini = date('N');
// Convert to system format (0-4 for Senin-Jumat)
$hari_sistem = $hari_ini - 1;

// Get schedule for this week
$query = "SELECT j.*, 
          k.nama_kelas, 
          m.nama_mapel, 
          r.nama_ruangan,
          DAYNAME(j.tanggal) as nama_hari
          FROM jadwal j
          JOIN kelas k ON j.kelas_id = k.id
          JOIN mata_pelajaran m ON j.mapel_id = m.id
          JOIN ruangan r ON j.ruangan_id = r.id
          WHERE j.guru_id = '$guru_id'
          AND YEARWEEK(j.tanggal, 1) = YEARWEEK(CURDATE(), 1)
          ORDER BY j.tanggal, j.jam_mulai";

$jadwal = $conn->query($query);

if (!$jadwal) {
    die("Database error: " . $conn->error);
}

// Group schedule by day
$jadwal_per_hari = [];
while ($row = $jadwal->fetch_assoc()) {
    $hari = date('N', strtotime($row['tanggal'])); // 1-7 (Monday-Sunday)
    $jadwal_per_hari[$hari][] = $row;
}

// Days list
$nama_hari = [
    1 => 'Senin',
    2 => 'Selasa',
    3 => 'Rabu',
    4 => 'Kamis',
    5 => 'Jumat',
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mengajar - SMK Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <style>
        .hari-aktif {
            background-color: #e9f7fe;
            border-left: 4px solid #0d6efd;
        }
        .card-jadwal {
            transition: transform 0.2s;
        }
        .card-jadwal:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="container px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Jadwal Mengajar</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a href="?minggu=sekarang" class="btn btn-sm btn-outline-secondary">Minggu Ini</a>
                    <a href="?minggu=depan" class="btn btn-sm btn-outline-secondary">Minggu Depan</a>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach ($nama_hari as $index => $hari): ?>
                <?php if ($index <= 7): // Only show school days ?>
                    <div class="col-md-6 mb-4">
                        <div class="card card-jadwal <?= $index == $hari_ini ? 'hari-aktif' : '' ?>">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><?= $hari ?></h5>
                            </div>
                            <div class="card-body">
                                <?php if (isset($jadwal_per_hari[$index]) && !empty($jadwal_per_hari[$index])): ?>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($jadwal_per_hari[$index] as $item): ?>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong><?= $item['nama_mapel'] ?></strong>
                                                        <div class="text-muted small">
                                                            <?= date('H:i', strtotime($item['jam_mulai'])) ?> - <?= date('H:i', strtotime($item['jam_selesai'])) ?>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge bg-secondary"><?= $item['nama_kelas'] ?></span>
                                                        <div class="text-muted small"><?= $item['nama_ruangan'] ?></div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <div class="text-center py-3 text-muted">
                                        Tidak ada jadwal mengajar
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Jadwal Mingguan dalam Tabel -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Rekap Jadwal Minggu Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead >
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jadwal_per_hari as $hari => $jadwal_hari): ?>
                                <?php foreach ($jadwal_hari as $item): ?>
                                    <tr>
                                        <td><?= $nama_hari[$hari] ?></td>
                                        <td><?= date('H:i', strtotime($item['jam_mulai'])) ?>-<?= date('H:i', strtotime($item['jam_selesai'])) ?></td>
                                        <td><?= $item['nama_mapel'] ?></td>
                                        <td><?= $item['nama_kelas'] ?></td>
                                        <td><?= $item['nama_ruangan'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            <?php if (empty($jadwal_per_hari)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Tidak ada jadwal mengajar minggu ini</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>