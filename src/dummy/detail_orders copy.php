<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Jawir.In - eCommerce Website</title>

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
            <!-- history barang dibeli  -->
            <div class="sidebar  has-scrollbar" data-productsle-menu>
               <div class="sidebar-top">
                  <h2 class="sidebar-title">Total Barang</h2>
                  <button class="sidebar-close-btn" data-productsle-menu-close-btn>
                     <ion-icon name="close-outline"></ion-icon>
                  </button>
               </div>
               <div class="sidebar-category">
                  <!-- query ambil data kategori -->
                  <?php
                  $select_orders = $conn->prepare("SELECT * FROM `orders`  ORDER BY id DESC LIMIT 10");
                  $select_orders->execute();
                  if ($select_orders->rowCount() > 0) {
                     while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                        <ul class="sidebar-menu-category-list">
                           <li class="sidebar-menu-category">
                              <button class="sidebar-accordion-menu" data-accordion-btn>
                                 <form action="" method="post" class="swiper-slide slide">
                                    <input type="hidden" name="name" value="<?= $fetch_orders['name']; ?>">
                                    <div class="menu-title-flex">
                                       <!-- <img src="./assets/images/icons/dress." alt="clothes" width="20" height="20" class="menu-title-img"> -->
                                       <a class="menu-title" href="category.php?category=<?= $fetch_orders['name']; ?>"><?= $fetch_orders['name']; ?></a>
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



                           </li>
                           <!--  -->
                        </ul>
               </div>
            </div>
            <!-- list pesanan user -->
            <div class="product-box">
               <!-- produk pesanan box -->
               <div class="product-main">
                  <h2 class="title"><i class="fa-solid fa-cart-shopping"></i> LIST PESANAN</h2>
                  <div class="product-grid">


                     <?php
                     $order_id = $_GET['order_id'];
                     $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
                     $select_orders->execute([$order_id]);
                     if ($select_orders->rowCount() > 0) {
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                     ?>
                           <div class="showcase-wrapper has-scrollbar">
                              <!-- query  -->

                              <div class="showcase-container">

                                 <div class="showcase">
                                    <!-- 
                              <a href="#" class="showcase-img-box">
                                 <img src="./assets/images/products/clothes-1.jpg" alt="relaxed short full sleeve t-shirt" width="70" class="showcase-img">
                              </a> -->

                                    <div class="showcase-content">

                                       <a href="#">
                                          <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">

                                          <h4 class="showcase-title"><i class="fa-solid fa-user"></i> <span><?= $fetch_orders['name']; ?></span> </h4>
                                          <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                                          <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
                                       </a>

                                       <a href="#" class="showcase-category"><i class="fa-solid fa-calendar"></i> <span><?= $fetch_orders['placed_on']; ?></span> </a>
                                       <a class="showcase-category">
                                          <p><i class="fa-solid fa-truck"></i> <span><?= $fetch_orders['method']; ?></span></p>
                                          <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
                                          <p>Nomor : <span><?= $fetch_orders['number']; ?></span></p>
                                          <p>Alamat : <span><?= $fetch_orders['address']; ?></span></p>
                                       </a>
                                       <div class="price-box">
                                          <p class="price"><span>Rp.<?= $fetch_orders['total_price']; ?>,00</span></p>

                                       </div>

                                       <!-- form untuk method post -->
                                       <form action="" method="post">
                                          <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">

                                          <!-- <p class="showcase-badge">TESTING</p> -->
                                          <div name="payment_status" class="kolom-field">
                                             <!-- <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                                          <option value="pending">pending</option>
                                          <option value="completed">completed</option> -->
                                             <p> <i class="fa-solid fa-paper-plane"></i> <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                                                               echo 'red';
                                                                                                            } else {
                                                                                                               echo 'green';
                                                                                                            }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                                          </div>
                                          <div class="price-box">
                                             <button type="submit" value="perbarui" class="btn btn-wishlist" name="update_payment"><i class="fa-solid fa-box"></i> kembali</button>
                                             <!-- <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="btn btn-delete" onclick="return confirm('hapus pesanan ini?');"><i class="fa-solid fa-trash"></i></a> -->
                                          </div>
                                       </form>
                                       <!-- end method post -->
                                    </div>

                                 </div>
                              </div>
                           </div>
                     <?php
                        }
                     } else {
                        echo '<p class="empty">tidak ada pesanan!</p>';
                     }

                     ?>
                  </div>
               </div>
               <!--  -->
            </div>
         </div>
      </div>
   </main>
   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>
   <script src="https://kit.fontawesome.com/8a136cd674.js" crossorigin="anonymous"></script>

</body>

</html>