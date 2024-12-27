<?php
// Memulai sesi untuk autentikasi
session_start();

// Menyertakan file konfigurasi database
include('config.php');

// Mengecek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Menyimpan data pendaftaran jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Membersihkan input pengguna
    $nama_lengkap = $conn->real_escape_string(trim($_POST['nama_lengkap']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $tanggal_lahir = $conn->real_escape_string(trim($_POST['tanggal_lahir']));
    $alamat = $conn->real_escape_string(trim($_POST['alamat']));
    $jenis_kelamin = $conn->real_escape_string(trim($_POST['jenis_kelamin']));
    $foto = '';
    $status = 'Menunggu'; // Status default
    $created_at = date('Y-m-d H:i:s'); // Timestamp untuk created_at

    // Proses upload gambar
    if (!empty($_FILES['foto']['name'])) {
        $foto = basename($_FILES['foto']['name']);
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . $foto;

        // Validasi tipe file
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = mime_content_type($_FILES['foto']['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $upload_file)) {
                $error_message = "Gagal mengupload gambar.";
            }
        } else {
            $error_message = "Format file tidak didukung. Gunakan JPG atau PNG.";
        }
    }

    // Validasi input email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Email tidak valid!";
    } elseif (!isset($error_message)) {
        // Menyimpan data ke database
        $query = "INSERT INTO pendaftaran (nama_lengkap, email, tanggal_lahir, alamat, jenis_kelamin, foto, status, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param(
                'ssssssss',
                $nama_lengkap,
                $email,
                $tanggal_lahir,
                $alamat,
                $jenis_kelamin,
                $foto,
                $status,
                $created_at
            );

            if ($stmt->execute()) {
                $success_message = "Pendaftaran berhasil! Anda akan diberitahu setelah diverifikasi.";
            } else {
                $error_message = "Terjadi kesalahan saat menyimpan data: " . $conn->error;
            }

            $stmt->close();
        } else {
            $error_message = "Terjadi kesalahan saat mempersiapkan query: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran PMR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <h3 class="text-center">Form Pendaftaran PMR</h3>

        <!-- Menampilkan pesan -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Form Pendaftaran -->
        <form action="pendaftaran.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required></textarea>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
        </form>
    </div>

    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
