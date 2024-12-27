<?php
// Memulai sesi untuk melacak status login
session_start();

// Memastikan pengguna sudah login dan memiliki akses admin
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'admin') {
    header("Location: home.php");
    exit();
}

// Menyertakan file konfigurasi database
include('config.php');

// Mengambil jumlah pendaftar menggunakan prepared statement
$query_pendaftaran = "SELECT COUNT(*) AS total_pendaftaran FROM pendaftaran";
$stmt_pendaftaran = $conn->prepare($query_pendaftaran);
$stmt_pendaftaran->execute();
$result_pendaftaran = $stmt_pendaftaran->get_result();
$total_pendaftaran = $result_pendaftaran->fetch_assoc()['total_pendaftaran'];

// Mengambil jumlah pengguna menggunakan prepared statement
$query_users = "SELECT COUNT(*) AS total_users FROM users";
$stmt_users = $conn->prepare($query_users);
$stmt_users->execute();
$result_users = $stmt_users->get_result();
$total_users = $result_users->fetch_assoc()['total_users'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pendaftaran PMR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h3 class="text-center">Admin Dashboard</h3>

        <div class="row mt-4">
            <!-- Total Pendaftar -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Pendaftaran</h5>
                        <p class="card-text"><?php echo $total_pendaftaran; ?> pendaftaran terdaftaran.</p>
                        <a href="pendaftaran.php" class="btn btn-primary">Lihat Pendaftaran</a>
                    </div>
                </div>
            </div>

            <!-- Total Pengguna -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengguna</h5>
                        <p class="card-text"><?php echo $total_users; ?> pengguna terdaftar.</p>
                        <a href="users.php" class="btn btn-primary">Lihat Pengguna</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tautan Aksi Admin -->
        <div class="mt-4">
            <h4>Kelola Sistem</h4>
            <div class="list-group">
                <a href="tambah_pendaftar.php" class="list-group-item list-group-item-action">Tambah Pendaftar Baru</a>
                <a href="manage_users.php" class="list-group-item list-group-item-action">Kelola Pengguna</a>
                <a href="laporan.php" class="list-group-item list-group-item-action">Unduh Laporan Pendaftar</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
