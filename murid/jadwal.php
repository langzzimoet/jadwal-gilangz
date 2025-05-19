<?php
include '../includes/auth_check.php';
include '../config/database.php';

$kelas_id = $_SESSION['user']['kelas_id'];

if (!$kelas_id) {
    die("Anda belum terdaftar di kelas manapun.");
}

// Get current day (1-7, where 1=Monday)
$hari_ini = date('N');
// Convert to system format (0-4 for Senin-Jumat)
$hari_sistem = $hari_ini - 1;

// Get schedule for this week
$query = "SELECT j.*, 
          m.nama_mapel, 
          u.nama as nama_guru,
          r.nama_ruangan,
          DAYNAME(j.tanggal) as nama_hari
          FROM jadwal j
          JOIN mata_pelajaran m ON j.mapel_id = m.id
          JOIN users u ON j.guru_id = u.id
          JOIN ruangan r ON j.ruangan_id = r.id
          WHERE j.kelas_id = '$kelas_id'
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
    5 => 'Jumat'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - Jadwalin</title>
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .jadwal-sekarang {
            background-color: #fff3cd !important;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <main class="container px-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Jadwal Pelajaran</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a href="?minggu=sekarang" class="btn btn-sm btn-outline-secondary">Minggu Ini</a>
                    <a href="?minggu=depan" class="btn btn-sm btn-outline-secondary">Minggu Depan</a>
                </div>
            </div>
        </div>

        <!-- Jadwal Hari Ini -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Jadwal Hari Ini (<?= $nama_hari[$hari_ini] ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (isset($jadwal_per_hari[$hari_ini]) && !empty($jadwal_per_hari[$hari_ini])): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $now = time();
                                $current_schedule = null;
                                foreach ($jadwal_per_hari[$hari_ini] as $item):
                                    $start = strtotime($item['jam_mulai']);
                                    $end = strtotime($item['jam_selesai']);
                                    $is_current = ($now >= $start && $now <= $end);
                                    ?>
                                    <tr class="<?= $is_current ? 'jadwal-sekarang' : '' ?>">
                                        <td><?= date('H:i', $start) ?> - <?= date('H:i', $end) ?></td>
                                        <td><strong><?= $item['nama_mapel'] ?></strong></td>
                                        <td><?= $item['nama_guru'] ?></td>
                                        <td><?= $item['nama_ruangan'] ?></td>
                                    </tr>
                                    <?php if ($is_current)
                                        $current_schedule = $item; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($current_schedule): ?>
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-info-circle"></i> Saat ini: <strong><?= $current_schedule['nama_mapel'] ?></strong>
                            dengan <?= $current_schedule['nama_guru'] ?> di <?= $current_schedule['nama_ruangan'] ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-3 text-muted">
                        Tidak ada jadwal pelajaran hari ini
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Jadwal Mingguan -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Jadwal Minggu Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Mapel</th>
                                <th>Guru</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($nama_hari as $index => $hari): ?>
                                <?php if ($index <= 7 && isset($jadwal_per_hari[$index])): ?>
                                    <?php foreach ($jadwal_per_hari[$index] as $item): ?>
                                        <tr>
                                            <td><?= $hari ?></td>
                                            <td><?= date('H:i', strtotime($item['jam_mulai'])) ?>-<?= date('H:i', strtotime($item['jam_selesai'])) ?>
                                            </td>
                                            <td><?= $item['nama_mapel'] ?></td>
                                            <td><?= $item['nama_guru'] ?></td>
                                            <td><?= $item['nama_ruangan'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if (empty($jadwal_per_hari)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Tidak ada jadwal pelajaran minggu
                                        ini</td>
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