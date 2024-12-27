<?php
// Memulai sesi untuk melacak status login
session_start();

// Memastikan pengguna sudah login dan memiliki akses admin
if (!isset($_SESSION['username']) || $_SESSION['level'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Menyertakan file konfigurasi database
include('config.php');

// Variabel untuk menampilkan pesan kesalahan
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari form
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $status = $_POST['status'];

    // Validasi input
    if (empty($nama) || empty($email) || empty($jenis_kelamin) || empty($status)) {
        $error = 'Semua field harus diisi!';
    } else {
        // Query untuk menyimpan data pendaftar ke database
        $query = "INSERT INTO pendaftar (nama, email, jenis_kelamin, status) 
                  VALUES ('$nama', '$email', '$jenis_kelamin', '$status')";
        
        // Menjalankan query
        if (mysqli_query($conn, $query)) {
            header('Location: index.php'); // Mengalihkan ke halaman utama pendaftaran setelah berhasil
            exit();
        } else {
            $error = 'Terjadi kesalahan saat menambahkan pendaftar!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pendaftar - Pendaftaran PMR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h3 class="text-center">Tambah Pendaftar PMR</h3>

        <!-- Menampilkan pesan kesalahan jika ada -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Form untuk menambah pendaftar -->
        <form action="tambah_pendaftar.php" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Tambah Pendaftar</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
