<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

// Get all jadwal with related data
$query = "SELECT j.*, 
          k.nama_kelas, 
          m.nama_mapel, 
          u.nama as nama_guru, 
          r.nama_ruangan,
          DAYNAME(CONCAT(j.tanggal, ' 00:00:00')) as nama_hari
          FROM jadwal j
          JOIN kelas k ON j.kelas_id = k.id
          JOIN mata_pelajaran m ON j.mapel_id = m.id
          JOIN users u ON j.guru_id = u.id
          JOIN ruangan r ON j.ruangan_id = r.id
          ORDER BY j.tanggal DESC, j.jam_mulai";

$jadwal = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jadwal - SMK Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table th {
            white-space: nowrap;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <?php include_once '../header_admin.php'; ?>
    <main class="container px-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Manajemen Jadwal</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="add.php" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Jadwal
                </a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                Jadwal berhasil <?php echo htmlspecialchars($_GET['success']); ?>!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="jadwalTable" class="table table-striped table-hover table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jam Ke</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Ruangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($row = $jadwal->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php echo date('Y-m-d', strtotime($row['tanggal'])); ?>
                                        <small class="text-muted d-block">(<?php echo $row['nama_hari']; ?>)</small>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['jam_ke'] . ' - ' . $row['sampai_jam_ke']); ?></td>
                                    <td><?php echo date('H:i', strtotime($row['jam_mulai'])); ?></td>
                                    <td><?php echo date('H:i', strtotime($row['jam_selesai'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_mapel']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_ruangan']); ?></td>
                                    <td class="action-buttons">
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                                            title="Hapus" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#jadwalTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                columnDefs: [
                    { orderable: false, targets: [9] } // Disable sorting for action column
                ]
            });
        });
    </script>
</body>

</html>