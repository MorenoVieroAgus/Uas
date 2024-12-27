<?php
// Konfigurasi untuk koneksi database
$host = 'localhost';      // Host database
$user = 'root';           // Username database
$password = '';           // Password database
$dbname = 'pendaftaran_pmr';          // Nama database yang digunakan

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $password, $dbname);

// Cek apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
