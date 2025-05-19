<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

// Get all teachers with their subjects
$query = "SELECT u.id, u.username, u.nama, u.created_at, 
          GROUP_CONCAT(m.nama_mapel SEPARATOR ', ') as mata_pelajaran
          FROM users u
          LEFT JOIN guru_mapel gm ON u.id = gm.guru_id
          LEFT JOIN mata_pelajaran m ON gm.mapel_id = m.id
          WHERE u.role = 'guru'
          GROUP BY u.id
          ORDER BY u.nama";

$guru = $conn->query($query);

if (!$guru) {
    die("Database error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Guru - SMK Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="../../../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include_once '../header_admin.php'; ?>
    <main class="container px-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Data Guru</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="add.php" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Guru
                </a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                Data guru berhasil <?php echo htmlspecialchars($_GET['success']); ?>!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="guruTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Mata Pelajaran</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($row = $guru->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['username']); ?></td>
                                    <td><?= htmlspecialchars($row['nama']); ?></td>
                                    <td><?= htmlspecialchars($row['mata_pelajaran'] ?? '-'); ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger"
                                            title="Hapus" onclick="return confirm('Hapus data guru ini?')">
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
            $('#guruTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                columnDefs: [
                    { orderable: false, targets: [5] } // Disable sorting for action column
                ]
            });
        });
    </script>
</body>

</html>