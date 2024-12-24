<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">
      <!-- Slick CSS -->
      <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
      <!-- Swiper Styles -->
      <!-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/swiper/swiper-bundle.min.css"> -->

      <link rel="stylesheet" href="CSS\shelter_header.css">

      <title>Papaw Care</title>
   </head>
   <body>
      <!--==================== HEADER ====================-->
      <header class="header" id="header">
        <nav class="nav container">
            <a href="#"  class="nav_logo">
                <img src="assets\PAPAW.svg" alt="papaw">Papaw Shelter
            </a>

            <div class="nav_menu" id="nav-menu">
                <ul class="nav_list">
                    <li>
                        <a href="shelter.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'shelter.php') echo 'active-link'; ?>">Home</a>
                    </li>
                    <!-- Menambahkan opsi Pelaporan -->
                    <li>
                        <a href="shelter_pelaporan.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'shelter_pelaporan.php') echo 'active-link'; ?>">Pelaporan</a>
                    </li>
                    <li>
                        <a href="adopsi_pelaporan.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'adopsi_pelaporan.php') echo 'active-link'; ?>">Adopsi</a>
                    </li>
                    <li>
                        <a href="donasi_pelaporan.php" class="nav_link <?php if(basename($_SERVER['PHP_SELF']) == 'donasi_pelaporan.php') echo 'active-link'; ?>">Donasi</a>
                    </li>
                        <a href="shelter_profile.php" class="nav_link user">
                            <img src="assets/profile.svg" alt="icon" srcset="">
                        </a>
                    </li>
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
      <script src="JS/script.js"></script>
    </body>
    </html>