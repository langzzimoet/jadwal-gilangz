<?php
session_start();

// Jika user sudah login, redirect ke dashboard sesuai role
if (isset($_SESSION['user'])) {
    header("Location: " . $_SESSION['user']['role'] . "/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwalin - Sistem Manajemen Jadwal Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-calendar-week"></i> Jadwalin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="auth/login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold mb-4">Sistem Manajemen Jadwal SMK</h1>
                    <p class="lead mb-4">Kelola jadwal pelajaran dengan mudah dan efisien untuk seluruh warga sekolah.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="auth/login.php" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk Sekarang
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="assets/img/school-schedule.png" alt="Ilustrasi Jadwal Sekolah" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-calendar-check fs-3"></i>
                            </div>
                            <h5>Manajemen Jadwal</h5>
                            <p class="text-muted">Kelola jadwal pelajaran dengan mudah dan fleksibel untuk semua kelas.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-people fs-3"></i>
                            </div>
                            <h5>Multi-Role Akses</h5>
                            <p class="text-muted">Akses berbeda untuk Admin, Guru, dan Siswa sesuai kebutuhan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-device-phone fs-3"></i>
                            </div>
                            <h5>Responsive Design</h5>
                            <p class="text-muted">Akses jadwal kapan saja dan di mana saja melalui perangkat apapun.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Cara Kerja Sistem</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 50px; height: 50px;">1</div>
                        <h5>Login</h5>
                        <p class="text-muted">Masuk dengan akun sesuai peran Anda</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 50px; height: 50px;">2</div>
                        <h5>Dashboard</h5>
                        <p class="text-muted">Lihat informasi penting di dashboard</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 50px; height: 50px;">3</div>
                        <h5>Kelola/Jadwal</h5>
                        <p class="text-muted">Admin kelola data, Guru/Siswa lihat jadwal</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 50px; height: 50px;">4</div>
                        <h5>Selesai</h5>
                        <p class="text-muted">Logout setelah selesai menggunakan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Tentang SMK Jadwal</h5>
                    <p>Sistem manajemen jadwal pelajaran untuk Sekolah Menengah Kejuruan yang efisien dan mudah
                        digunakan.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="auth/login.php" class="text-white">Login</a></li>
                        <li><a href="#" class="text-white">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kontak</h5>
                    <address>
                        SMK Negeri 1 Contoh<br>
                        Jl. Pendidikan No. 123<br>
                        Kota Contoh, 12345
                    </address>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> SMK Jadwal. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>