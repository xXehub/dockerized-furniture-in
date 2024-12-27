<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/wishlist_cart.php';

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

   <!--- css link lur, eksternal btw-->
   <link rel="stylesheet" href="./assets/css/style_sakkarepmu.css">

   <!--- google font link-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>

   <?php include 'components/user_header.php'; ?>
   <main>
      <div class="product-container">
         <div class="container">

            <!-- KATEGORI KIRI -->
            <div class="sidebar  has-scrollbar" data-productsle-menu>
               <div class="sidebar-top">
                  <h2 class="sidebar-title">KATEGORI</h2>

                  <button class="sidebar-close-btn" data-productsle-menu-close-btn>
                     <ion-icon name="close-outline"></ion-icon>
                  </button>
               </div>
               <div class="sidebar-category">
                  <!-- query ambil data kategori -->
                  <?php
                  $select_products = $conn->prepare("SELECT DISTINCT kategori FROM products LIMIT 5");
                  $select_products->execute();
                  if ($select_products->rowCount() > 0) {
                     while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                        <ul class="sidebar-menu-category-list">
                           <li class="sidebar-menu-category">
                              <button class="sidebar-accordion-menu" data-accordion-btn>
                                 <form action="" method="post" class="swiper-slide slide">
                                    <input type="hidden" name="name" value="<?= $fetch_products['kategori']; ?>">
                                    <div class="menu-title-flex">
                                       <!-- <img src="./assets/images/icons/dress." alt="clothes" width="20" height="20" class="menu-title-img"> -->
                                       <a class="menu-title"><?= $fetch_products['kategori']; ?></a>
                                    </div>
                                 </form>
                           <?php
                        }
                     } else {
                        echo '<p class="empty">no products added yet!</p>';
                     }
                           ?>
                           <!-- <div>
                                                <ion-icon name="add-outline" class="add-icon"></ion-icon>
                                                <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                                            </div> -->

                              </button>

                              <ul class="sidebar-submenu-category-list" data-accordion>

                                 <li class="sidebar-submenu-category">
                                    <a href="#" class="sidebar-submenu-title">
                                       <p class="product-name">Shirt</p>
                                       <data value="300" class="stock" title="Available Stock">300</data>
                                    </a>
                                 </li>

                                 <li class="sidebar-submenu-category">
                                    <a href="#" class="sidebar-submenu-title">
                                       <p class="product-name">shorts & jeans</p>
                                       <data value="60" class="stock" title="Available Stock">60</data>
                                    </a>
                                 </li>

                                 <li class="sidebar-submenu-category">
                                    <a href="#" class="sidebar-submenu-title">
                                       <p class="product-name">jacket</p>
                                       <data value="50" class="stock" title="Available Stock">50</data>
                                    </a>
                                 </li>

                                 <li class="sidebar-submenu-category">
                                    <a href="#" class="sidebar-submenu-title">
                                       <p class="product-name">dress & frock</p>
                                       <data value="87" class="stock" title="Available Stock">87</data>
                                    </a>
                                 </li>

                              </ul>

                           </li>
                           <!--  -->
                        </ul>

               </div>


            </div>

            <?php

            // Tampilkan pesan kesalahan jika ada
            if (isset($_SESSION["error_message"])) {
               echo "<div class='error'>{$_SESSION["error_message"]}</div>";
               unset($_SESSION["error_message"]);
            }
            ?>

            <!-- end kategori -->

            <!--
            - PRODUCT FEATURED
          -->
            <div class="product-box">
               <div class="product-featured">
                  <div class="product-featured">

                     <h2 class="title">DETAIL PRODUK</h2>

                     <div class="showcase-wrapper has-scrollbar">

                        <div class="showcase-container">

                           <div class="showcase">
                              <!-- query -->
                              <?php
                              $pid = $_GET['pid'];
                              $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                              $select_products->execute([$pid]);
                              if ($select_products->rowCount() > 0) {
                                 while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                              ?>
                                    <form action="" method="post" class="box">
                                       <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                       <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">


                                       <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                                       <input type="hidden" name="details" value="<?= $fetch_products['details']; ?>">
                                       <input type="hidden" name="kategori" value="<?= $fetch_products['kategori']; ?>">
                                       <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                                       <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">


                                       <!-- <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="Mens Winter Leathers Jackets" width="300" class="product-img default">
                                    <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="Mens Winter Leathers Jackets" width="300" class="product-img hover"> -->

                                       <div class="showcase-banner">
                                          <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="shampoo, conditioner & facewash packs" width="75" height="75" class="showcase-img">
                                       </div>


                                       <div class="showcase-content">

                                          <!-- <div class="showcase-rating">
                                          <ion-icon name="star"></ion-icon>
                                          <ion-icon name="star"></ion-icon>
                                          <ion-icon name="star"></ion-icon>
                                          <ion-icon name="star-outline"></ion-icon>
                                          <ion-icon name="star-outline"></ion-icon>
                                       </div> -->

                                          <a href="#">
                                             <h3 class="showcase-title"><?= $fetch_products['name']; ?></h3>
                                          </a>

                                          <p class="showcase-desc">
                                             <?= $fetch_products['details']; ?>
                                          </p>

                                          <div class="price-box">
                                             <p class="price"><span>IDR <?= $fetch_products['price']; ?></span></p>

                                          </div>

                                          <div class="container">
                                             <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                                             <button type="submit" class="add-cart-btn" name="add_to_cart" value="tambahkan ke keranjang"><i class="fa-solid fa-cart-shopping"></i> </button>
                                             <button metod="post" class="add-cart-btn" name="add_to_wishlist" value="tambahkan ke wishlist"><i class="fa-solid fa-heart"></i> </button>


                                          </div>
                                    </form>
                                    <!-- <div class="showcase-status">
                                    <div class="wrapper">
                                       <p>
                                          already sold: <b>20</b>
                                       </p>

                                       <p>
                                          available: <b>40</b>
                                       </p>
                                    </div>

                                    <div class="showcase-status-bar"></div>
                                 </div> -->
                                    <!-- 
                                 <div class="countdown-box">

                                    <p class="countdown-desc">
                                       Hurry Up! Offer ends in:
                                    </p>

                                    <div class="countdown">

                                       <div class="countdown-content">

                                          <p class="display-number">360</p>

                                          <p class="display-text">Days</p>

                                       </div>

                                       <div class="countdown-content">
                                          <p class="display-number">24</p>
                                          <p class="display-text">Hours</p>
                                       </div>

                                       <div class="countdown-content">
                                          <p class="display-number">59</p>
                                          <p class="display-text">Min</p>
                                       </div>

                                       <div class="countdown-content">
                                          <p class="display-number">00</p>
                                          <p class="display-text">Sec</p>
                                       </div>

                                    </div>

                                 </div> -->
                           </div>
                        </div>
                  <?php
                                 }
                              } else {
                                 echo '<p class="empty">no products found!</p>';
                              }
                  ?>

                     </div>



                  </div>

               </div>






            </div>

         </div>
      </div>

      </div>






      </div>
</body>
</main>






<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<script src="https://kit.fontawesome.com/8a136cd674.js" crossorigin="anonymous"></script>

</body>

</html>