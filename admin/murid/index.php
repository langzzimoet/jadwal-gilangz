<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

$query = "SELECT u.id, u.username as nis, u.nama, 
          k.nama_kelas, u.created_at
          FROM users u
          LEFT JOIN kelas k ON u.kelas_id = k.id
          WHERE u.role = 'murid'
          ORDER BY u.created_at DESC";

$murid = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Murid - SMK Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="../../../assets/css/style.css" rel="stylesheet">
    <style>
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            margin-right: 0.25rem;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <?php include '../header_admin.php'; ?>

    <main class="container px-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Data Murid</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="add.php" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Murid
                </a>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                Data murid berhasil <?= htmlspecialchars($_GET['success']) ?>!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="muridTable" class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($row = $murid->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nis']) ?></td>
                                    <td><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= $row['nama_kelas'] ?? '-' ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                    <td class="action-buttons">
                                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="reset_password.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info"
                                            title="Reset Password">
                                            <i class="bi bi-key"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                            title="Hapus" onclick="return confirm('Hapus data murid ini?')">
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
            $('#muridTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                columnDefs: [
                    { orderable: false, targets: [5] } // Disable sort for action column
                ]
            });
        });
    </script>
</body>

</html>