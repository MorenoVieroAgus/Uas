<?php
include('config/db.php');  // Include the database configuration

// Start session to track user login
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: daftar_pendaftaran.php");
    exit();
}

// If the user ID is passed through GET or POST, fetch the registration status
$user_id = $_SESSION['user_id']; // assuming user is logged in

// Query to check the registration status of the user
$query = "SELECT * FROM pendaftaran WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

// Fetch the registration status
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $status = $row['status']; // assuming 'status' column stores registration status
} else {
    $status = "Belum terdaftar"; // Default message if no registration found
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <h2>Status Pendaftaran</h2>
        <p>Selamat datang, Anda dapat melihat status pendaftaran PMR Anda di bawah ini:</p>

        <div class="status">
            <h3>Status Anda: 
                <?php 
                    if ($status == "Terverifikasi") {
                        echo "<span class='badge success'>$status</span>";
                    } elseif ($status == "Pending") {
                        echo "<span class='badge pending'>$status</span>";
                    } else {
                        echo "<span class='badge failure'>$status</span>";
                    }
                ?>
            </h3>
        </div>

        <a href="pendaftaran.php" class="btn btn-primary">Edit Pendaftaran</a>
    </div>

    <?php include('ooter.php'); ?>
</body>
</html>
