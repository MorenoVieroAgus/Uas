<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="index.php">Pendaftaran PMR</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Halaman Home -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <!-- Halaman Pendaftar (untuk admin) -->
                <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="daftar_pendaftaran.php">Daftar Pendaftar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laporan.php">Laporan</a>
                    </li>
                <?php endif; ?>

                <!-- Halaman Pendaftaran -->
                <li class="nav-item">
                    <a class="nav-link" href="pendaftaran.php">Pendaftaran</a>
                </li>

                <!-- Menu untuk logout -->
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
