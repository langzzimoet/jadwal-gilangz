<?php include '../config/database.php';

// Data pengguna dari session
$current_role = $_SESSION['user']['role'];
$nama = $_SESSION['user']['nama'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiJapel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Navbar Styling */
        .navbar {
            padding: 0.8rem 1rem;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .avatar-container {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .nav-link {
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover .avatar-container {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .dropdown-menu {
            border: none;
            border-radius: 0.5rem;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.35em 0.65em;
        }
    </style>
</head>

<body>
    <!-- Header and Navbar -->
    <header class="navbar navbar-expand-lg navbar-dark sticky-top bg-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <!-- <i class="bi bi-calendar-check me-2"></i> -->
                <img src="<?php echo $base_url; ?>assets/img/logo.png" class="me-2" style="width: 30px; height: 30px;">
                <span class="fw-bold">SiJapel</span>
                <span class="badge bg-primary ms-2"><?php echo ucfirst($current_role); ?></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $base_url . $current_role; ?>/dashboard.php">
                            <i class="bi bi-speedometer2 me-2"></i>
                            Dashboard
                        </a>
                    </li>

                    <?php if ($current_role == 'guru'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url . 'guru/jadwal.php'; ?>">
                                <i class="bi bi-calendar-week me-2"></i>
                                Jadwal Mengajar
                            </a>
                        </li>
                    <?php elseif ($current_role == 'murid'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url . 'murid/jadwal.php'; ?>">
                                <i class="bi bi-calendar-week me-2"></i>
                                Jadwal Pelajaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url . 'murid/profile.php'; ?>">
                                <i class="bi bi-person-circle me-2"></i>
                                Profil
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="dropdownUser"
                            data-bs-toggle="dropdown">
                            <div class="avatar-container me-2">
                                <i class="bi bi-person-circle fs-4"></i>
                            </div>
                            <div class="user-info">
                                <span class="d-block fw-bold"><?php echo $nama; ?></span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="<?php echo $base_url; ?>auth/logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    <span>Sign out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>

</html>