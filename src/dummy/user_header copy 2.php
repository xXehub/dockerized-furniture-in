<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
   }
}
// perintah untuk logout
if (isset($_POST["logout"])) {
   session_destroy();
   header("Location: home");
   exit();
}
?>



<div class="overlay" data-overlay></div>

<!--- MODAL-->

<!-- <div class="modal" data-modal>
   <div class="modal-close-overlay" data-modal-overlay></div>
   <div class="modal-content">
      <button class="modal-close-btn" data-modal-close>
         <ion-icon name="close-outline"></ion-icon>
      </button>
      <div class="newsletter-img">
         <img src="./assets/images/newsletter.png" alt="subscribe newsletter" width="400" height="400">
      </div>
      <div class="newsletter">
         <form action="#">
            <div class="newsletter-header">
               <h3 class="newsletter-title">Subscribe Newsletter.</h3>
               <p class="newsletter-desc">
                  Subscribe the <b>Toko Asia Mebel</b> to get latest products and discount update.
               </p>
            </div>
            <input type="email" name="email" class="email-field" placeholder="Email Address" required>
            <button type="submit" class="btn-newsletter">Subscribe</button>
         </form>

      </div>
   </div>
</div> -->




<!--- NOTIFICATION TOAST-->
<!-- <div class="notification-toast" data-toast>
   <button class="toast-close-btn" data-toast-close>
      <ion-icon name="close-outline"></ion-icon>
   </button>
   <div class="toast-banner">
      <img src="./assets/images/products/jewellery-1.jpg" alt="Rose Gold Earrings" width="80" height="70">
   </div>
   <div class="toast-detail">
      <p class="toast-message">
         Someone in new just bought
      </p>
      <p class="toast-title">
         Rose Gold Earrings
      </p>
      <p class="toast-meta">
         <time datetime="PT2M">2 Minutes</time> ago
      </p>
   </div>
</div> -->
<header class="header">
   <section class="flex">
      <div class="header-top">
         <div class="container">
            <ul class="header-social-container">
               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-facebook"></ion-icon>
                  </a>
               </li>
               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-twitter"></ion-icon>
                  </a>
               </li>
               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-instagram"></ion-icon>
                  </a>
               </li>
               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-linkedin"></ion-icon>
                  </a>
               </li>
            </ul>
            <div class="header-alert-news">
               <?php
               $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_profile->execute([$user_id]);
               if ($select_profile->rowCount() > 0) {
                  $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
               ?>
                  <p>
                     Halo
                     <b>
                        <?= $fetch_profile["name"]; ?>
                     </b> Selamat Datang
                  </p>
                  <div id="user-btn">
                     <!-- <a href="components/user_logout" class="logout-button">Logout</a> -->
                  </div>
               <?php
               } else {
               ?>
                  <div id="user-btn">
                     <p>
                        <b></b>
                        Selamat Datang, Silahkan Masuk Terlebih Dahulu
                     </p>
                     <!-- <a href="user_register" class="btn btn-login">register</a> -->
                     <!-- <a href="user_login" class="user-btn">login</a> -->
                  </div>
               <?php
               }
               ?>

            </div>
            <div class="header-top-actions">
               <select name="currency">
                  <option value="usd">IDR</option>
                  <option value="eur">EUR &euro;</option>
               </select>
               <select name="language">
                  <option value="en-US">Indonesia</option>
                  <option value="es-ES">Espa&ntilde;ol</option>
                  <option value="fr">Fran&ccedil;ais</option>
               </select>
            </div>
         </div>
      </div>
      <div class="header-main">

         <div class="container">

            <a href="#" class="header-logo">
               <img src="./assets/images/logo/sofa.jpg" alt="Toko Asia Mebel's logo" width="120" height="50">
               <!-- <img src="./assets/images/logo/telu.png" alt="Toko Asia Mebel's logo" width="120" height="36"> -->
            </a>

            <div class="header-search-container">
               <!-- search query -->


               <!-- end -->
               <!-- <section class="search-form">
                  <form action="" method="post">
                     <input type="text" name="search_box" placeholder="cari produk..." maxlength="100" class="box" required>
                     <button type="submit" class="fas fa-search" name="search_btn"></button>
                  </form>
               </section> -->
               <section class="search-form">
                  <form action="" method="post">
                     <input type="text" name="search_box" class="search-field" placeholder="Masukan Nama Produk..." required>

                     <button class="search-btn" name="search_btn">
                        <ion-icon name="search-outline"></ion-icon>
                     </button>
                  </form>
               </section>
            </div>

            <!-- popup login -->



            <!-- sampe kene  -->
            <div class="header-user-actions">
               <!-- codingan query ne su -->
               <?php
               $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
               $count_wishlist_items->execute([$user_id]);
               $total_wishlist_counts = $count_wishlist_items->rowCount();

               $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
               $count_cart_items->execute([$user_id]);
               $total_cart_counts = $count_cart_items->rowCount();
               ?>
               <!-- iki melbu ndek user setting -->

               <!-- sampek kene -->
               <div class="icons">
                  <?php
                  $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                  $count_wishlist_items->execute([$user_id]);
                  $total_wishlist_counts = $count_wishlist_items->rowCount();

                  $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                  $count_cart_items->execute([$user_id]);
                  $total_cart_counts = $count_cart_items->rowCount();
                  ?>

               </div>


               <!-- query ambil user -->
               <?php
               $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_profile->execute([$user_id]);
               if ($select_profile->rowCount() > 0) {
                  $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
               ?>

                  <div id="user-btn">
                     <button class="action-btn">
                        <a href="components/user_logout" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?');"><ion-icon name="log-out-outline"></ion-icon></a>
                        <span class="count">
                           <?= $fetch_profile["name"]; ?>
                        </span>
                        <!-- <span class="count">0</span> -->
                     </button>
                     <!-- <a href="components/user_logout" class="logout-button">Logout</a> -->
                     <!-- <a href="user_login"><ion-icon name="log-out-outline"></ion-icon></a> -->
                  </div>

               <?php

               } else {
               ?>
                  <div id="user-btn">
                     <!-- <a href="user_register" class="btn btn-login">register</a> -->
                     <!-- <div id="user-btn"> -->
                     <button class="action-btn">
                        <a href="user_login"><ion-icon name="log-in-outline"></ion-icon></a>
                        <span class="count">
                           login
                        </span>
                        <!-- <span class="count">0</span> -->
                     </button>
                     <!-- <a href="user_login"><ion-icon name="log-in-outline"></ion-icon></a> -->
                     <!-- <a href="user_login" class="user-btn">login</a> -->
                  </div>
               <?php
               }
               ?>
               <button class="action-btn">
                  <a href="wishlist"><ion-icon name="heart-outline"></ion-icon></a>
                  <span class="count">
                     <?= $total_wishlist_counts; ?>
                  </span>
                  <!-- <span class="count">0</span> -->
               </button>
               <button class="action-btn">

                  <a href="cart"><ion-icon name="bag-handle-outline"></ion-icon></a>
                  <span class="count">
                     <?= $total_cart_counts; ?>
                  </span>
                  <!-- <span class="count">0</span> -->

               </button>
               <div class="profile">

                  <?php
                  $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_profile->execute([$user_id]);
                  if ($select_profile->rowCount() > 0) {
                     $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                  ?>
                     <p>
                        <?= $fetch_profile["name"]; ?>
                     </p>
                     <a href="update_user" class="btn">update profile</a>
                     <div class="flex-btn">
                        <a href="user_register" class="option-btn">register</a>
                        <a href="user_login" class="option-btn">login</a>
                     </div>
                     <a href="components/user_logout" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a>

                  <?php
                  } else {
                  ?>
                     <p>please login or register first!</p>
                     <div class="flex-btn">
                        <a href="user_register" class="option-btn">register</a>
                        <a href="user_login" class="option-btn">login</a>
                     </div>
                  <?php
                  }
                  ?>


               </div>

            </div>
         </div>
      </div>
      <nav class="desktop-navigation-menu">

         <div class="container">
            <!-- query ambil data kategori -->

            <ul class="desktop-menu-category-list">

               <li class="menu-category">


                  <a href="home" class="menu-title">Home</a>
               </li>
               <!-- kategorine wir jawir -->
           



               <li class="menu-category">
                  <a href="orders" class="menu-title">Pesanan</a>
               </li>

            </ul>

         </div>

      </nav>

      <div class="mobile-bottom-navigation">

         <button class="action-btn" data-mobile-menu-open-btn>
            <ion-icon name="menu-outline"></ion-icon>
         </button>

         <button class="action-btn">
            <ion-icon name="bag-handle-outline"></ion-icon>

            <span class="count">0</span>
         </button>

         <button class="action-btn">
            <ion-icon name="home-outline"></ion-icon>
         </button>

         <button class="action-btn">
            <ion-icon name="heart-outline"></ion-icon>

            <span class="count">0</span>
         </button>

         <button class="action-btn" data-mobile-menu-open-btn>
            <ion-icon name="grid-outline"></ion-icon>
         </button>

      </div>

      <nav class="mobile-navigation-menu  has-scrollbar" data-mobile-menu>

         <div class="menu-top">
            <h2 class="menu-title">Menu</h2>

            <button class="menu-close-btn" data-mobile-menu-close-btn>
               <ion-icon name="close-outline"></ion-icon>
            </button>
         </div>

         <!-- tampilan responsive nde hp lur -->

         <ul class="mobile-menu-category-list">

            <li class="menu-category">
               <a href="#" class="menu-title"><i class="fa-solid fa-house-chimney"></i> Home</a>
            </li>

            <li class="menu-category">

               <button class="accordion-menu" data-accordion-btn>
                  <p class="menu-title">Men's</p>

                  <div>
                     <ion-icon name="add-outline" class="add-icon"></ion-icon>
                     <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                  </div>
               </button>

               <ul class="submenu-category-list" data-accordion>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Shirt</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Shorts & Jeans</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Safety Shoes</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Wallet</a>
                  </li>

               </ul>

            </li>

            <li class="menu-category">

               <button class="accordion-menu" data-accordion-btn>
                  <p class="menu-title">Women's</p>

                  <div>
                     <ion-icon name="add-outline" class="add-icon"></ion-icon>
                     <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                  </div>
               </button>

               <ul class="submenu-category-list" data-accordion>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Dress & Frock</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Earrings</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Necklace</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Makeup Kit</a>
                  </li>

               </ul>

            </li>

            <li class="menu-category">

               <button class="accordion-menu" data-accordion-btn>
                  <p class="menu-title">Jewelry</p>

                  <div>
                     <ion-icon name="add-outline" class="add-icon"></ion-icon>
                     <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                  </div>
               </button>

               <ul class="submenu-category-list" data-accordion>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Earrings</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Couple Rings</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Necklace</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Bracelets</a>
                  </li>

               </ul>

            </li>

            <li class="menu-category">

               <button class="accordion-menu" data-accordion-btn>
                  <p class="menu-title">Perfume</p>

                  <div>
                     <ion-icon name="add-outline" class="add-icon"></ion-icon>
                     <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                  </div>
               </button>

               <ul class="submenu-category-list" data-accordion>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Clothes Perfume</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Deodorant</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Flower Fragrance</a>
                  </li>

                  <li class="submenu-category">
                     <a href="#" class="submenu-title">Air Freshener</a>
                  </li>

               </ul>

            </li>

            <li class="menu-category">
               <a href="#" class="menu-title">Blog</a>
            </li>

            <li class="menu-category">
               <a href="#" class="menu-title">Hot Offers</a>
            </li>

         </ul>

         <div class="menu-bottom">

            <ul class="menu-category-list">

               <li class="menu-category">

                  <button class="accordion-menu" data-accordion-btn>
                     <p class="menu-title">Language</p>

                     <ion-icon name="caret-back-outline" class="caret-back"></ion-icon>
                  </button>

                  <ul class="submenu-category-list" data-accordion>

                     <li class="submenu-category">
                        <a href="#" class="submenu-title">Indonesia</a>
                     </li>

                     <li class="submenu-category">
                        <a href="#" class="submenu-title">Espa&ntilde;ol</a>
                     </li>

                     <li class="submenu-category">
                        <a href="#" class="submenu-title">Fren&ccedil;h</a>
                     </li>

                  </ul>

               </li>

               <li class="menu-category">
                  <button class="accordion-menu" data-accordion-btn>
                     <p class="menu-title">Currency</p>
                     <ion-icon name="caret-back-outline" class="caret-back"></ion-icon>
                  </button>

                  <ul class="submenu-category-list" data-accordion>
                     <li class="submenu-category">
                        <a href="#" class="submenu-title">IDR</a>
                     </li>

                     <li class="submenu-category">
                        <a href="#" class="submenu-title">EUR &euro;</a>
                     </li>
                  </ul>
               </li>

            </ul>

            <ul class="menu-social-container">

               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-facebook"></ion-icon>
                  </a>
               </li>

               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-twitter"></ion-icon>
                  </a>
               </li>

               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-instagram"></ion-icon>
                  </a>
               </li>

               <li>
                  <a href="#" class="social-link">
                     <ion-icon name="logo-linkedin"></ion-icon>
                  </a>
               </li>

            </ul>

         </div>

      </nav>
   </section>

   <script src="./js/script.js"></script>
   <!--- ionicon link-->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   <script src="https://kit.fontawesome.com/8a136cd674.js" crossorigin="anonymous"></script>
</header>