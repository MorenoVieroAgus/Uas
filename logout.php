<?php
// Memulai sesi untuk autentikasi
session_start();

// Menghancurkan sesi untuk keluar
session_destroy();

// Mengarahkan pengguna kembali ke halaman login
header('Location: login.php');
exit();
?>
