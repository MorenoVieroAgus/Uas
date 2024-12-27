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

// Mendapatkan ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Mendapatkan data dari tabel `pendaftaran`
    $query = "SELECT * FROM pendaftaran WHERE id = '$id'";
    $result = $conn->query($query);

    if (!$result) {
        die("Query Error: " . $conn->error);
    }

    $row = $result->fetch_assoc();
} else {
    // Jika tidak ada ID, arahkan ke halaman laporan
    header('Location: laporan.php');
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $status = $_POST['status'];

    // Update query
    $update_query = "UPDATE pendaftaran SET 
                     nama_lengkap = '$nama_lengkap', 
                     email = '$email', 
                     tanggal_lahir = '$tanggal_lahir', 
                     alamat = '$alamat', 
                     jenis_kelamin = '$jenis_kelamin', 
                     status = '$status' 
                     WHERE id = '$id'";

    if ($conn->query($update_query)) {
        header('Location: laporan.php'); // Redirect to laporan page after update
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Edit Pendaftaran</h3>
        <form action="edit_pendaftaran.php?id=<?php echo $row['id']; ?>" method="POST">
            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($row['nama_lengkap']); ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($row['tanggal_lahir']); ?>" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($row['alamat']); ?></textarea>
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L" <?php echo ($row['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?php echo ($row['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Terverifikasi" <?php echo ($row['status'] == 'Terverifikasi') ? 'selected' : ''; ?>>Terverifikasi</option>
                    <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Belum terdaftar" <?php echo ($row['status'] == 'Belum terdaftar') ? 'selected' : ''; ?>>Belum terdaftar</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
