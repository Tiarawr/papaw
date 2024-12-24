<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
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

      <link rel="stylesheet" href="CSS\style.css">

      <title>Papaw Care</title>
   </head>
   <body>
      <!--==================== HEADER ====================-->
      <?php require_once('header.php'); ?>

      <!--==================== MAIN ====================-->
      <main class="main">
         <!--==================== HOME ====================-->
         <section class="home section" id="home">
            <div class="home_container container grid">
                <div class="home_data">
                    <h1 class="home_title">Help them <br> to be happy</h1>
                        <p class="home_description">
                        Reporting an abandoned animal? Here, you can help animals find loving homes, simply by contacting the nearest shelter.
                        </p>
                        <a href="pelaporan.php" class="button" >Find shelter</a>

                        <img src="assets/litle-dog.png" alt="image" class="home_sticker-1">
                        <img src="assets/paw.png" alt="image" class="home_sticker-2">
                

                    
                </div>

                <div class="home_images">
                        <img src="assets\pet.png" alt="image" class="home_pet">

                    </div>
            </div>
         </section>

         <!--==================== ADOPTION ====================-->
         <section class="adopsi section" id="adopsi">
            <div class="adopsi_container container grid">
                <div class="adopsi_data">
                    <h2 class="section_title">Together <br/>save them</h2>

                    <p class="adopsi_description">
                      Thousands of hopeful eyes await the opportunity to give this heartfelt love to you. Each animal here has a story that will touch your heart, and they are ready to write a new chapter of their lives - with you.
                    </p>

                    <a href="adopsi.php" class="button">Adopsi</a>
                </div>

                <img src="assets\adopsi.png" alt="image" class="adopsi_img">
            </div>
         </section>

         <!--==================== DONATION ====================-->
         <section class="donasi section" id="donasi">
            <div class="donasi_container container grid">
                    <div class="donasi_data">
                        <h2 class="section_title">Help them <br/>to live better</h2>
                        <p class="donasi_description">
                            Let's move together to give new hope to those who have no voice. Your donation today is a second chance for them to experience love and a better life.
                        </p>

                        <a href="#donasi" class="button">Donasi</a>
                    </div>
                    <img src="assets\donasi.png" alt="image" class="donasi_img">
                </div>
         </section>

         <!--==================== ARTIKEL ====================-->
        <section class="artikel section" id="artikel">
            <div class="artikel_container container grid">
                <div class="artikel_data">
                    <h2 class="section_title">Artikel</h2>
                    <a href="artikel.php" class="nav_link">more</a>
                </div>

                <div class="articles-grid swiper-container">
                    <!-- Swiper Wrapper -->
                    <div class="swiper-wrapper">
                        <?php
                        // Koneksi ke database
                        require 'koneksi.php';

                        // Mengambil query pencarian (jika ada)
                        $search_query = isset($_GET['search']) ? $_GET['search'] : '';

                        // Query untuk mengambil artikel, jika ada kata kunci pencarian
                        if ($search_query) {
                            $sql = "SELECT * FROM artikel WHERE judul LIKE ? OR konten LIKE ? ORDER BY tanggal_publish DESC LIMIT 3";
                            $stmt = $conn->prepare($sql);
                            $search_term = "%" . $search_query . "%";
                            $stmt->bind_param("ss", $search_term, $search_term);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        } else {
                            $sql = "SELECT * FROM artikel ORDER BY tanggal_publish DESC LIMIT 3";
                            $result = $conn->query($sql);
                        }

                        // Menampilkan artikel
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                // Artikel dibungkus dalam <a> untuk mengarah ke artikel lengkap
                                echo "<div class='swiper-slide article-card' style='background-image: url(\"assets/img/" . $row['gambar'] . "\");'>";
                                echo "<a href='artikel-lengkap.php?id_artikel=" . $row['id_artikel'] . "' class='article-overlay'>";
                                echo "<div class='article-content'>";
                                echo "<p>" . substr($row['konten'], 0, 100) . "...</p>";
                                echo "</div>";
                                echo "</a>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Tidak ada artikel yang ditemukan untuk kata kunci: <strong>" . htmlspecialchars($search_query) . "</strong></p>";
                        }

                        $conn->close();
                        ?>
                    </div>

                    <!-- Swiper Pagination (Optional) -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>



         <!--==================== CONTACT ====================-->
         <section class="contact section" id="contact">
            <div class="contact_container container grid">
                <div class="contact_data">
                    <h2 class="section_title">Contact & address</h2>

                    <div class="contact_info grid">
                        <div>
                            <h3 class="contact_title">Write Us</h3>

                            <div class="contact_social">
                                <a href="" target="_blank" class="contact_social-link">
                                    <i class="ri-whatsapp-fill"></i>
                                </a>
                                <a href="" target="_blank" class="contact_social-link">
                                    <i class="ri-mail-fill"></i>
                                </a>
                                <a href="" target="_blank" class="contact_social-link">
                                    <i class="ri-telegram-2-fill"></i>
                                </a>
                            </div>
                        </div>

                        <!-- <div>
                            <h3 class="contact_title">Media</h3>
                            <div class="contact_media">
                                <ul>
                                    <li><a href="">
                                        <i class="ri-youtube-line"></i> <span>Youtube</span> 
                                    </a></li>
                                    <li><a href="">
                                        <i class="ri-instagram-line"></i> <span>Instagram</span>
                                    </a></li>
                                </ul>
                            </div>
                        </div> -->

                        <div>
                            <h3 class="contact_title">Location</h3>

                            <address class="contact_address">
                            Unnes, Gd. Rektorat, Lt. 1, Sekaran, Kec. Gn. Pati<br>
                            Kota Semarang, Jawa Tengah 50229
                            </address>
                            <a href="https://maps.app.goo.gl/1G5gRoeREZJg23ob8" target="_blank" class="contact_map">
                                <i class="ri-road-map-fill"></i>
                                <span>View on map</span>
                            </a>
                        </div>
                    </div>

                </div>
                
                <div class="contact_image">
                    <img src="assets\dogcat.svg" alt="image" class="contact_img">
                </div>
            </div>    
         </section>
      </main>

      <!--==================== FOOTER ====================-->
      <!-- <footer class="footer">
         <div class="footer_container container grid">
            <a href="" class="footer_logo">Papaw Care</a>

         </div>
         <div class="footer_copy">

            <div class="footer_content grid">
                <div>
                    <h3 class="footer_title">Social</h3>

                    <div class="footer_social">
                        <a href="" class="footer_social-link">
                            <i class="ri-facebook-circle-fill"></i>
                        </a>
                        <a href="" class="footer_social-link">
                            <i class="ri-instagram-line"></i>
                        </a>
                        <a href="" class="footer_social-link">
                            <i class="ri-youtube-line"></i>
                        </a>
                    </div>
                </div>

                <div>
                     <h3 class="footer_title">Payment Methods</h3>

                    <div class="footer_pay">
                            <img src="assets\footer-card-1.png" alt="image" class="footer_pay-img">
                            <img src="assets\footer-card-2.png" alt="image" class="footer_pay-img">
                            <img src="assets\footer-card-3.png" alt="image" class="footer_pay-img">
                            <img src="assets\footer-card-4.png" alt="image" class="footer_pay-img">
                    </div>
                </div>

                <div>
                    <h3 class="footer_title">Subscribe for news info</h3>

                    <form action="" class="footer_form">
                        <input type="email" placeholder="Email" class="footer_input">
                        <button type="submit" class="footer_button button">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="footer_policy">
            <a href="" class="footer_link">Terms & Agreements</a>
            <a href="" class="footer_link">Privacy Policy</a>
        </div>

        <span class="footer_copy">
            &#169; All Rights Reserved By Kelompok 9
        </span>
      </footer> -->
      <?php require_once('footer.php'); ?>

      <!--========== SCROLL UP ==========-->
      <a href="#" class="scrollup" id="scroll-up">
        <i class="ri-arrow-up-line"></i>
      </a>

      <!-- Slick JS -->
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


      <!-- Swiper Script -->
      <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
      <!-- Scroll Reveal -->
      <script src="JS\scrollreveal.min.js"></script>
      <!--=============== MAIN JS ===============-->
      <script src="JS/script.js"></script>
   </body>
</html>