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

// Mengambil semua data pendaftar dari database
$query = "SELECT * FROM pendaftar ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pendaftar PMR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
            h3 {
                text-align: center;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <div class="container mt-5">
        <h3 class="text-center">Laporan Pendaftar PMR</h3>

        <!-- Tombol untuk Mencetak Laporan -->
        <button onclick="window.print()" class="btn btn-primary mb-3 no-print">Cetak Laporan</button>

        <!-- Tabel Daftar Pendaftar -->
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
                // Menampilkan data pendaftar
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['nama']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['jenis_kelamin']."</td>";
                        echo "<td>".$row['status']."</td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data pendaftar</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
