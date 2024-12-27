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

// Menggunakan library FPDF untuk membuat PDF (harus diinstal terlebih dahulu)
require('fpdf/fpdf.php');

// Fungsi untuk menghasilkan PDF
if (isset($_GET['generate_pdf'])) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Judul laporan
    $pdf->Cell(190, 10, 'Laporan Pendaftar PMR', 0, 1, 'C');
    $pdf->Ln(10);

    // Header tabel
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Nama', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Email', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Jenis Kelamin', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Status', 1, 1, 'C');

    // Mengisi data pendaftar ke dalam tabel
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(40, 10, $row['nama'], 1, 0, 'L');
        $pdf->Cell(40, 10, $row['email'], 1, 0, 'L');
        $pdf->Cell(30, 10, $row['jenis_kelamin'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['status'], 1, 1, 'C');
    }

    // Output PDF ke browser dan memulai download
    $pdf->Output('D', 'Laporan_Pendaftar_PM.pdf');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Laporan Pendaftar PMR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <div class="container mt-5">
        <h3 class="text-center">Download Laporan Pendaftar PMR</h3>

        <!-- Tombol untuk Mengunduh Laporan PDF -->
        <form action="download_laporan.php" method="GET" class="mb-3">
            <button type="submit" name="generate_pdf" class="btn btn-primary">Download Laporan PDF</button>
        </form>

        <!-- Menampilkan Data Pendaftar (Tabel) -->
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
