<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
};

if (isset($_POST['add_product'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $kategori = $_POST['kategori'];
   $kategori = filter_var($kategori, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/' . $image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/' . $image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/' . $image_03;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if ($select_products->rowCount() > 0) {
      $message[] = 'product name already exist!';
   } else {

      $insert_products = $conn->prepare("INSERT INTO `products`(name, kategori ,details, price, image_01, image_02, image_03) VALUES(?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $kategori, $details, $price, $image_01, $image_02, $image_03]);

      if ($insert_products) {
         if ($image_size_01 > 2000000 or $image_size_02 > 2000000 or $image_size_03 > 2000000) {
            $message[] = 'image size is too large!';
         } else {
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'new product added!';
         }
      }
   }
};

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/' . $fetch_delete_image['image_01']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_02']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:products.php');
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

   <!--- css link lur, eksternal btw-->
   <link rel="stylesheet" href="../assets/css/style_sakkarepmu.css">

   <!--- google font link-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
   <!--- HEADER -->
   <?php include '../components/admin_header.php'; ?>
   <!--- MAIN-->
   <main>
      <!--- BANNER-->
      
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
                                       <a class="menu-title" href="category.php?category=<?= $fetch_products['kategori']; ?>"><?= $fetch_products['kategori']; ?></a>
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
            
            </div>

            <div class="product-box">

               <!--- PRODUCT GRID-->
               <div class="product-main">

                  <h2 class="title"><i class="fa-solid fa-boxes-stacked"></i> PRODUK</h2>
                  <div class="product-grid">
                     <!-- query search -->

                     <?php
                     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 12");
                     $select_products->execute();
                     if ($select_products->rowCount() > 0) {
                        while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                     ?>
                           <form action="" method="post" class="swiper-slide slide">
                              <div class="showcase">
                                 <div class="showcase-banner">
                                    <!-- gawe post (array key) -->
                                    <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                                    <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                                    <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                                    <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                                    <input type="hidden" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">


                                    <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="Gambare lur" width="300" class="product-img default">
                                    <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="Gambare2 lur" width="300" class="product-img hover">
                                    <!-- <p class="showcase-badge">TESTING</p> -->

                                    <div href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="showcase-actions">

                                       <p style="color:red;">
                                          <?php
                                          if (isset($_SESSION['error'])) {
                                             echo $_SESSION['error'];
                                             unset($_SESSION['error']);
                                          }
                                          ?>
                                       </p>
                                       <button href="products.php?delete=<?= $fetch_products['id']; ?>" class="btn-action" type="submit" onclick="return confirm('anda yakin hapus produk ini?');">
                                          <ion-icon name="trash-outline"></ion-icon>
                                       </button>
                                       <a  href="update_product.php?update=<?= $fetch_products['id']; ?>" class="btn-action">
                                          <ion-icon  href="update_product.php?update=<?= $fetch_products['id']; ?>" name="eye-outline"></ion-icon>
                                       </a>
                                       <!-- <button class="btn-action">
                                       <ion-icon name="repeat-outline"></ion-icon>
                                    </button>
                                    <button class="btn-action">
                                       <ion-icon name="bag-add-outline"></ion-icon>
                                    </button> -->
                                    </div>
                                 </div>
                                 <div class="showcase-content">
                                    <a class="showcase-category" href="quick_view.php?pid=<?= $fetch_product['id']; ?> "><?= $fetch_product['kategori']; ?></a>
                                    <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>">
                                       <h3 class="showcase-title" href="quick_view.php?pid=<?= $fetch_product['id']; ?>"><?= $fetch_product['name']; ?></h3>
                                       <!-- <h3 class="showcase-isilur">sdsdsd</h3> -->
                                    </a>
                                    <!-- <div class="showcase-rating">
                                          <ion-icon name="star"></ion-icon>
                                          <ion-icon name="star"></ion-icon>
                                          <ion-icon name="star"></ion-icon>
                                          <ion-icon name="star-outline"></ion-icon>
                                          <ion-icon name="star-outline"></ion-icon>
                                       </div> -->
                                    <div class="price-box">
                                       <p class="price" id="dengan-rupiah"><span>Rp.</span><?= $fetch_product['price']; ?></p>

                                 
                                       <!--  
                                       <input type="number" name="qty" class="kuantitas-field" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                                       -->
                                       <!-- <del>IDR 75.00</del> -->
                                    </div>
                                 </div>
                              </div>
                              <!-- <input type="submit" value="tambahkan ke keranjang" class="btn btn-login" name="add_to_cart"> -->
                           </form>
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
      </div>
      </div>
   </main>
   <!-- footer -->
   <?php include '../components/footer.php'; ?>
   <!-- jawir script -->
   <script src="js/script.js"></script>
   <!-- ion icon -->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>


</html>