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
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Toko Asia Mebel - eCommerce Website</title>

   <!--- favicon-->
   <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!--- css link lur, eksternal btw-->
   <link rel="stylesheet" href="../assets/css/style_sakkarepmu.css">

   <!--- google font link-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
      rel="stylesheet">

</head>
<div class="overlay" data-overlay></div>
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
               <p>
                  <b>Free Ongkir</b>
                  SIWALANKERTO - WONOKROMO
               </p>
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
               <img src="../assets/images/logo/telu.png" alt="Toko Asia Mebel's logo" width="120" height="50">
               <!-- <img src="./assets/images/logo/telu.png" alt="Toko Asia Mebel's logo" width="120" height="36"> -->
            </a>

            <div class="header-search-container">

               <input type="search" name="search" class="search-field" placeholder="Masukan Nama Produk...">

               <button class="search-btn">
                  <ion-icon name="search-outline"></ion-icon>
               </button>

            </div>
            <!-- popup login -->
            <div class="header-user-actions">
            <?php
            // Query to get admin profile data
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            if ($select_profile->rowCount() > 0) {
               // Fetch admin profile
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
               ?>

               <div id="admin-btn">
                  <button class="action-btn">
                     <a href="../components/admin_logout.php" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?');">
                        <ion-icon name="log-out-outline"></ion-icon>
                     </a>

                     <span class="count">
                        <?= $fetch_profile["name"]; ?>
                     </span>
                  </button>
               </div>

               <?php
            } else {
               // If no profile is found, show login link
               ?>
               <div id="admin-btn">
                  <button class="action-btn">
                     <a href="admin_login.php">
                        <ion-icon name="log-in-outline"></ion-icon>
                     </a>
                     <span class="count">Login</span>
                  </button>
               </div>
            <?php } ?>

            </div>
           
            <!-- sampe kene  -->
         </div>
      </div>
      <nav class="desktop-navigation-menu">

         <div class="container">

            <ul class="desktop-menu-category-list">

               <li class="menu-category">
                  <a href="../admin/dashboard.php" class="menu-title"><i class="fa-solid fa-house-chimney"></i>
                     Dashboard</a>
               </li>
               <!-- kategorine wir jawir -->
               <!-- produk -->
               <li class="menu-category">
                  <a href="../admin/products.php" class="menu-title"><i class="fa-solid fa-box"></i> Produk</a>
               </li>
               <li class="menu-category">
                  <a href="../admin/tambah_products.php" class="menu-title"><i class="fa-solid fa-box"></i> Tambah
                     Produk</a>
               </li>
               <!-- pesanan -->
               <li class="menu-category">
                  <a href="../admin/placed_orders.php" class="menu-title"><i class="fa-solid fa-truck"></i> Pesanan</a>
               </li>

               <!-- pesanan -->

            </ul>


      </nav>
   </section>

   <script src="../assets/js/script.js"></script>
   <!--- ionicon link-->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</header>