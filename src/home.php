<?php
ob_start();
session_start();
include 'components/connect.php';

// Jika user sudah login, ambil user_id dari session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

// Periksa jika ada pesan dari session (misalnya, login berhasil atau logout berhasil)
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);  // Hapus pesan setelah ditampilkan
}
include 'components/wishlist_cart.php';
?>



<!-- Konten halaman home.php lainnya -->

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Toko Asia Mebel - eCommerce Website</title>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!--- favicon-->
   <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">

   <!--- css link lur, eksternal btw-->
   <link rel="stylesheet" href="./assets/css/style_sakkarepmu.css">

   <!--- google font link-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
      rel="stylesheet">
</head>

<body>
   <!--- HEADER -->
   <?php include 'components/user_header.php'; ?>
   <!--- MAIN-->
   <main>
      <!--- BANNER-->
      <div class="banner">
         <div class="container">
            <div class="slider-container has-scrollbar">
               <div class="slider-item">
                  <img src="./assets/images/Quirky-house-Banner.jpg" alt="women's latest fashion sale"
                     class="banner-img">
                  <div class="banner-content">
                     <p class="banner-subtitle">Trending item</p>
                     <h2 class="banner-title">Toko Asia Mebel</h2>
                     <p class="banner-text">
                        starting at IDR <b>200.000</b>.00
                     </p>
                     <a href="./transaksi/detail.php" class="banner-btn">Beli Sekarang</a>
                  </div>
               </div>
               <!-- <div class="slider-item">
                  <img src="./assets/images/.jpg" alt="modern sunglasses" class="banner-img">
                  <div class="banner-content">
                     <p class="banner-subtitle">Trending set</p>
                     <h2 class="banner-title">Modern Kitchen Set</h2>
                     <p class="banner-text">
                        starting at IDR <b>150.000</b>.00
                     </p>
                     <a href="#" class="banner-btn">Beli Sekarang</a>
                  </div>
               </div>

               <div class="slider-item">
                  <img src="./assets/images/.jpg" alt="new fashion summer sale" class="banner-img">
                  <div class="banner-content">
                     <p class="banner-subtitle">Sale Offer</p>
                     <h2 class="banner-title">New Modern Sofa</h2>
                     <p class="banner-text">
                        starting at IDR <b>300.000</b>.99
                     </p>
                     <a href="#" class="banner-btn">Shop now</a>
                  </div>
               </div> -->
            </div>
         </div>
      </div>
      <!-- Kategori -->
      <!-- <div class="category">
         <div class="container">
            <div class="category-item-container has-scrollbar">
               <div class="category-item">
                  <div class="category-img-box">
                     <img src="./assets/images/icon_sakkarepmu/armchair.webp" alt="Armschair" width="30">
                  </div>
                  <div class="category-content-box">
                     <div class="category-content-flex">
                        <h3 class="category-item-title">Armschair</h3>
                        <p class="category-item-amount">(53)</p>
                     </div>
                     <a href="#" class="category-btn">Tampilkan Semua</a>
                  </div>
               </div>
               <div class="category-item">

                  <div class="category-img-box">
                     <img src="./assets/images/icon_sakkarepmu/beds.webp" alt="winter wear" width="30">
                  </div>
                  <div class="category-content-box">
                     <div class="category-content-flex">
                        <h3 class="category-item-title">Beds</h3>
                        <p class="category-item-amount">(58)</p>
                     </div>
                     <a href="#" class="category-btn">Tampilkan Semua</a>
                  </div>
               </div>
               <div class="category-item">
                  <div class="category-img-box">
                     <img src="./assets/images/icon_sakkarepmu/couch.webp" alt="Couch" width="30">
                  </div>
                  <div class="category-content-box">
                     <div class="category-content-flex">
                        <h3 class="category-item-title">Couch</h3>
                        <p class="category-item-amount">(68)</p>
                     </div>
                     <a href="#" class="category-btn">Tampilkan Semua</a>
                  </div>
               </div>
               <div class="category-item">
                  <div class="category-img-box">
                     <img src="./assets/images/icon_sakkarepmu/sofaset.webp" alt="Sofa Set" width="30">
                  </div>
                  <div class="category-content-box">
                     <div class="category-content-flex">
                        <h3 class="category-item-title">Sofa Set</h3>
                        <p class="category-item-amount">(27)</p>
                     </div>
                     <a href="#" class="category-btn">Tampilkan Semua</a>
                  </div>
               </div>
               <div class="category-item">
                  <div class="category-img-box">
                     <img src="./assets/images/icon_sakkarepmu/matress.webp" alt="Matress" width="30">
                  </div>
                  <div class="category-content-box">
                     <div class="category-content-flex">
                        <h3 class="category-item-title">Matress</h3>
                        <p class="category-item-amount">(35)</p>
                     </div>
                     <a href="#" class="category-btn">Tampilkan Semua</a>
                  </div>
               </div>
               <div class="category-item">
                  <div class="category-img-box">
                     <img src="./assets/images/icon_sakkarepmu/dinningtable.webp" alt="Dinning Table" width="30">
                  </div>
                  <div class="category-content-box">
                     <div class="category-content-flex">
                        <h3 class="category-item-title">Dinning Table</h3>
                        <p class="category-item-amount">(84)</p>
                     </div>
                     <a href="#" class="category-btn">Tampilkan Semua</a>
                  </div>
               </div>
               <div class="category-item">
                  <div class="category-img-box">
                     <img src="./assets/images/icon_sakkarepmu/ottoman.webp" alt="Ottoman" width="30">
                  </div>
                  <div class="category-content-box">
                     <div class="category-content-flex">
                        <h3 class="category-item-title">Ottoman</h3>
                        <p class="category-item-amount">(16)</p>
                     </div>
                     <a href="#" class="category-btn">Tampilkan Semua</a>
                  </div>
               </div>


               

            </div>
         </div>
      </div> -->
      <!--- PRODUCT SIDEBAR -->
      <div class="product-container">
         <div class="container">
            <!-- KATEGORI KIRI -->
            <div class="sidebar  has-scrollbar" data-productsle-menu>
               <div class="sidebar-top">
                  <h2 class="sidebar-title"><i class="fa-solid fa-book"></i> KATEGORI</h2>

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
                                       <a class="menu-title"
                                          href="category.php?category=<?= $fetch_products['kategori']; ?>"><?= $fetch_products['kategori']; ?></a>
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



               <!-- <div class="sidebar  has-scrollbar" data-mobile-menu> -->
               <div class="product-showcase">
                  <h3 class="showcase-heading"><i class="fa-solid fa-box"></i>
                     <P>Terbaru</P>
                  </h3>
                  <div class="showcase-wrapper">
                     <div class="showcase-container">
                        <?php
                        $select_products = $conn->prepare("SELECT * FROM `products`  ORDER BY id DESC LIMIT 3");
                        $select_products->execute();
                        if ($select_products->rowCount() > 0) {
                           while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                              ?>
                              <div class="showcase">

                                 <a href="#" class="showcase-img-box">
                                    <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="baby fabric shoes"
                                       width="75" height="75" class="showcase-img">
                                 </a>
                                 <div class="showcase-content">
                                    <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>">
                                       <h4 class="showcase-title"><?= $fetch_product['name']; ?></h4>
                                    </a>
                                    <!-- <div class="showcase-rating">
                                       <ion-icon name="star"></ion-icon>
                                       <ion-icon name="star"></ion-icon>
                                       <ion-icon name="star"></ion-icon>
                                       <ion-icon name="star"></ion-icon>
                                       <ion-icon name="star"></ion-icon>
                                    </div> -->
                                    <div class="price-box">
                                       <!-- <del>$5.00</del> -->
                                       <p class="price"></span>Rp. <?= $fetch_product['price']; ?></p>
                                    </div>
                                 </div>


                              </div>

                              <?php
                           }
                        } else {
                           echo '<p class="empty">no products added yet!</p>';
                        }
                        ?>
                     </div>
                  </div>
               </div>
            </div>

            <div class="product-box">

               <!--- PRODUCT GRID-->
               <div class="product-main">
                  <?php
                  // Set the number of products per page
                  $products_per_page = 12;

                  // Get the current page number from the URL (default is 1)
                  if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                     $current_page = $_GET['page'];
                  } else {
                     $current_page = 1;
                  }

                  // Calculate the starting product based on the current page
                  $start_from = ($current_page - 1) * $products_per_page;

                  // Get the total number of products in the database
                  $total_products_query = $conn->prepare("SELECT COUNT(*) FROM `products`");
                  $total_products_query->execute();
                  $total_products = $total_products_query->fetchColumn();

                  // Calculate the total number of pages
                  $total_pages = ceil($total_products / $products_per_page);

                  // Fetch products for the current page
                  $select_products = $conn->prepare("SELECT * FROM `products` LIMIT :start_from, :products_per_page");
                  $select_products->bindParam(':start_from', $start_from, PDO::PARAM_INT);
                  $select_products->bindParam(':products_per_page', $products_per_page, PDO::PARAM_INT);
                  $select_products->execute();

                  ?>

                  <!-- Display products -->
                  <h2 class="title"><i class="fa-solid fa-boxes-stacked"></i> PRODUK</h2>
                  <div class="product-grid">
                     <?php
                     if ($select_products->rowCount() > 0) {
                        while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                           ?>
                           <form action="" method="post" class="swiper-slide slide">
                              <div class="showcase">
                                 <div class="showcase-banner">
                                    <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                                    <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                                    <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                                    <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                                    <input type="hidden" name="qty" class="qty" min="1" max="99"
                                       onkeypress="if(this.value.length == 2) return false;" value="1">

                                    <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="Gambare lur" width="300"
                                       class="product-img default">
                                    <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="Gambare2 lur" width="300"
                                       class="product-img hover">
                                    <!-- <p class="showcase-badge">TESTING</p> -->

                                    <div class="showcase-actions">
                                       <button class="btn-action" type="submit" name="add_to_wishlist">
                                          <ion-icon name="heart-outline"></ion-icon>
                                       </button>

                                       <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="btn-action">
                                          <ion-icon name="eye-outline"></ion-icon>
                                       </a>
                                       <button class="btn-action" type="submit" name="add_to_cart" min="1" max="99"
                                          onkeypress="if(this.value.length == 2) return false;" value="1">
                                          <ion-icon name="cart-outline"></ion-icon>
                                       </button>
                                    </div>
                                 </div>
                                 <div class="showcase-content">
                                    <a class="showcase-category"
                                       href="quick_view.php?pid=<?= $fetch_product['id']; ?>"><?= $fetch_product['kategori']; ?></a>
                                    <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>">
                                       <h3 class="showcase-title"><?= $fetch_product['name']; ?></h3>
                                    </a>
                                    <div class="price-box">
                                       <p class="price" id="dengan-rupiah"><span>Rp.</span><?= $fetch_product['price']; ?></p>
                                    </div>
                                 </div>
                              </div>
                           </form>
                           <?php
                        }
                     } else {
                        echo '<p class="empty">tidak ada produk untuk ditampilkan!</p>';
                     }
                     ?>
                  </div>
                  <div class="pagination">
                     <?php if ($current_page > 1) { ?>
                        <a href="?page=<?= $current_page - 1; ?>" class="arrow">&#60;</a>
                     <?php } else { ?>
                        <a class="arrow" disabled>&#60;</a>
                     <?php } ?>

                     <?php for ($page = 1; $page <= $total_pages; $page++) { ?>
                        <a href="?page=<?= $page; ?>"
                           class="page-link <?= ($page == $current_page) ? 'active' : ''; ?>"><?= $page; ?></a>
                     <?php } ?>

                     <?php if ($current_page < $total_pages) { ?>
                        <a href="?page=<?= $current_page + 1; ?>" class="arrow">&#62;</a>
                     <?php } else { ?>
                        <a class="arrow" disabled>&#62;</a>
                     <?php } ?>
                  </div>


               </div>
            </div>
         </div>
      </div>
   </main>
   <!-- footer -->
   <?php include 'components/footer.php'; ?>
   <!-- jawir script -->
   <script src="js/script.js"></script>
   <!-- ion icon -->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   <?php if (isset($message)): ?>
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '<?php echo $message; ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
        
    <?php endif; ?>
    
</body>

</html>