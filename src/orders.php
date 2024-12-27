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
            <!-- history barang dibeli  -->
            <div class="sidebar  has-scrollbar" data-productsle-menu>
            <div class="product-showcase">
                  <h3 class="showcase-heading">Produk Terbaru</h3>
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
                                    <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="baby fabric shoes" width="75" height="75" class="showcase-img">
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
            <!-- list pesanan user -->
            <div class="product-box">
               <!-- produk pesanan box -->
               <div class="product-main">
                  <h2 class="title"><i class="fa-solid fa-cart-shopping"></i> LIST PESASNAN</h2>
                  <div class="product-grid">
                     <?php
                     if ($user_id == '') {
                        echo '<p class="empty">silahkan login untuk melihat pesanan anda</p>';
                     } else {
                        $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                        $select_orders->execute([$user_id]);
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
                                             <h4 class="showcase-title"><i class="fa-solid fa-user"></i> <span><?= $fetch_orders['name']; ?></span> </h4>
                                          </a>

                                          <a href="#" class="showcase-category"><i class="fa-solid fa-calendar"></i> <span><?= $fetch_orders['placed_on']; ?></span> </a>
                                          <a class="showcase-category">
                                             <p><i class="fa-solid fa-truck"></i> <span><?= $fetch_orders['method']; ?></span></p>

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
                                                <!-- <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a> -->
                                                <a href="detail_orders.php?order_id=<?= $fetch_orders['id']; ?>" class="btn btn-wishlist"><i class="fa-solid fa-box"></i> detail</a>
                                                <!-- <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="btn btn-delete" onclick="return confirm('hapus pesanan ini?');"><i class="fa-solid fa-trash"></i></a> -->
                                             </div>
                                          </form>
                                          <!-- end method post -->
                                       </div>

                                    </div>
                                 </div>

                                 <!-- 
                                 <div class="showcase-container">

                                    new arrival 2
                                 </div> -->

                              </div>
                     <?php
                           }
                        } else {
                           echo '<p class="empty">tidak ada pesanan!</p>';
                        }
                     }
                     ?>
                  </div>




               </div>
               <!--  -->

            </div>

            <!-- <section class="orders"> -->

            <!-- 
                  <h1 class="heading">pesanan</h1>

                  <div class="box-container">

            
                  </div> -->

            <!-- </section> -->

         </div>
      </div>

   </main>
   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>
   <script src="https://kit.fontawesome.com/8a136cd674.js" crossorigin="anonymous"></script>

</body>

</html>