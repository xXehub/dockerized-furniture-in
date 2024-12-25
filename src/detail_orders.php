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
           <div class="sidebar  has-scrollbar" data-mobile-menu>
            <div class="product-showcase">
               <h3 class="showcase-heading">Pesanan Anda</h3>
               <div class="showcase-wrapper">
                  <div class="showcase-container">
                     <!-- <section class="checkout-orders"> -->
                     <form action="" method="POST">
                        <!-- <h3>Pesanan Anda</h3> -->
                        <div class="display-orders">
                        <?php
                     $order_id = $_GET['order_id'];
                     $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
                     $select_orders->execute([$order_id]);
                     if ($select_orders->rowCount() > 0) {
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                     ?>

                                 <!--  -->
   
                           <?php
                              }
                           } else {
                              echo '<b class="empty">keranjang anda kosong!</b>';
                           }
                           ?>

     
                        </div>
                  </div>
               </div>
            </div>
         </div>
            <!-- list pesanan user -->
            <div class="product-box">
               <h2 class="title"><i class="fa-solid fa-cart-shopping"></i> LIST PESANAN</h2>
               <!-- produk pesanan box -->
               <div class="product-main">

                  <div class="">


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

                                    <div class="product-grid">

                                       <a href="#">
                                          <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">

                                          <h4 class="showcase-title"><i class="fa-solid fa-user"></i> <span><?= $fetch_orders['name']; ?></span> </h4>
                                          <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                                          <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
                                       </a>
                                       <a href="#" class="showcase-category"><i class="fa-solid fa-calendar"></i> <span><?= $fetch_orders['placed_on']; ?></span> </a>
                                       <a class="showcase-title"><i class="fa-solid fa-envelope"></i> <?= $fetch_orders['email']; ?></a>
                                    </div>
                                    <div class="product-grid">
                                       <a class="showcase-title"><i class="fa-solid fa-truck"></i> <span><?= $fetch_orders['method']; ?></span></a>
                                       <a class="showcase-title"><i class="fa-solid fa-phone"></i> <?= $fetch_orders['number']; ?></a>
                                       <a class="showcase-title"><i class="fa-solid fa-house"></i> <?= $fetch_orders['address']; ?></a>
                                    </div>
                                    <a class="showcase-title">Pesanan Anda : </a>
                                       <div class="kolom-field">
                                          <a class="showcase-category"><span><?= $fetch_orders['total_products']; ?></span></a>
                                       </div>
                                    </div>
                                    <div class="price-box">
                                       <b class="price">Rp.<?= $fetch_orders['total_price']; ?>,00</b>
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
                                          <a href="orders.php" type="submit" value="perbarui" class="btn btn-wishlist" name="update_payment"><i class="fa-solid fa-box"></i> kembali</a>
                                          <!-- <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="btn btn-delete" onclick="return confirm('hapus pesanan ini?');"><i class="fa-solid fa-trash"></i></a> -->
                                       </div>
                                    </form>
                                    <!-- end method post -->


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