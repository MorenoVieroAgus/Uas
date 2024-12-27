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

// Variabel untuk menampung hasil pencarian
$search_result = [];

// Memeriksa apakah ada kata kunci pencarian
if (isset($_POST['search'])) {
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    
    // Query untuk mencari pendaftar berdasarkan nama atau email
    $query = "SELECT * FROM pendaftar WHERE nama LIKE '%$keyword%' OR email LIKE '%$keyword%' ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    
    // Menyimpan hasil pencarian ke dalam array
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $search_result[] = $row;
        }
    } else {
        $search_result = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Pendaftar PMR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <div class="container mt-5">
        <h3 class="text-center">Pencarian Pendaftar PMR</h3>

        <!-- Form Pencarian -->
        <form action="search.php" method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="keyword" placeholder="Cari berdasarkan nama atau email" required>
                <button type="submit" name="search" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <!-- Tabel Hasil Pencarian -->
        <?php if (isset($search_result) && count($search_result) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Menampilkan hasil pencarian
                    $no = 1;
                    foreach ($search_result as $row) {
                        echo "<tr>";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['nama']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['jenis_kelamin']."</td>";
                        echo "<td>".$row['status']."</td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Tidak ada data yang ditemukan.
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
