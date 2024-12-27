<?php
// Memulai sesi untuk melacak status login
session_start();

// Menyertakan file konfigurasi database
include('config.php');

// Mengecek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Mendapatkan informasi pengguna
$username = $_SESSION['username'];

// Menampilkan pesan selamat datang
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Sistem Pendaftaran PMR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h3>Selamat datang</h3>
        <p>Ini adalah halaman utama untuk pengguna.</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pendaftaran PMR</h5>
                        <p class="card-text">Silakan daftar sebagai anggota PMR di sini.</p>
                        <a href="pendaftaran.php" class="btn btn-primary">Daftar Sekarang</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lihat Pendaftaran</h5>
                        <p class="card-text">Lihat status pendaftaran Anda di sini.</p>
                        <a href="status_pendaftaran.php" class="btn btn-primary">Lihat Status</a>
                    </div>
                </div>
            </div>


    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
