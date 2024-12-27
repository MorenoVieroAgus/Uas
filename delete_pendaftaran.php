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

// Memeriksa apakah ID peserta ada dalam URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data pendaftaran
    $query = "DELETE FROM pendaftaran WHERE id = '$id'";

    if ($conn->query($query)) {
        header('Location: laporan.php'); // Setelah berhasil, arahkan ke halaman laporan
        exit();
    } else {
        die("Error: " . $conn->error); // Menampilkan pesan error jika query gagal
    }
} else {
    // Jika ID tidak ada, arahkan kembali ke halaman laporan
    header('Location: laporan.php');
    exit();
}
?>
