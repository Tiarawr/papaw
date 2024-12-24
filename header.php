<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="CSS\header.css">
    <title>Papaw Care</title>
</head>
<body>
    <!--==================== HEADER ====================-->
    <header class="header" id="header">
        <nav class="nav container">
            <a href="#" class="nav_logo">
                <img src="assets\PAPAW.svg" alt="papaw">Papaw
            </a>

            <div class="nav_menu" id="nav-menu">
                <ul class="nav_list">
                    <li>
                        <a href="index.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'index.php') echo 'active-link'; ?>">Home</a>
                    </li>
                    <!-- Menambahkan opsi Pelaporan -->
                    <li>
                        <a href="pelaporan.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'pelaporan.php') echo 'active-link'; ?>">Pelaporan</a>
                    </li>
                    <li>
                        <a href="adopsi.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'adopsi.php') echo 'active-link'; ?>">Adopsi</a>
                    </li>
                    <li>
                        <a href="donasi.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'donasi.php') echo 'active-link'; ?>">Donasi</a>
                    </li>
                    <li>
                        <a href="artikel.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'artikel.php') echo 'active-link'; ?>">Artikel</a>
                    </li>
                    

                    <!-- Tampilkan tombol Login jika belum login -->
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="login.php" class="nav_link login">Login</a>
                        </li>
                    <?php endif; ?>

                    <!-- Tampilkan tombol User Profile jika sudah login -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="user_profile.php" class="nav_link user">
                            <img src="assets/profile.svg" alt="icon" srcset=""></a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Close button -->
                <div class="nav_close" id="nav-close">
                    <i class="ri-close-fill"></i>
                </div>
            </div>

            <!-- Toggle button -->
            <div class="nav_toggle" id="nav-toggle">
                <i class="ri-apps-2-fill"></i>
            </div>
        </nav>
    </header>

    <!--=============== MAIN JS ===============-->
    <script src="JS/header.js"></script>
</body>
</html>
