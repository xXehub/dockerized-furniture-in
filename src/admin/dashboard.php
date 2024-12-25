<?php
session_start();
include '../components/connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Verify admin exists in database
$verify_admin = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$verify_admin->execute([$admin_id]);

if ($verify_admin->rowCount() == 0) {
    session_unset();
    session_destroy();
    header('location:admin_login.php');
    exit();
}

// Rest of your dashboard code here...
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!--- css link lur, eksternal btw-->
   <link rel="stylesheet" href="../assets/css/style_sakkarepmu.css">
   

   <!--- google font link-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <div class="product-container">
      <div class="container">
      <div class="sidebar  has-scrollbar" data-mobile-menu>
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

                           <a href="#" class="showcase-img-kolom-field">
                              <img src="../uploaded_img/<?= $fetch_product['image_01']; ?>" alt="baby fabric shoes" width="75" height="75" class="showcase-img">
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
                              <div class="price-kolom-field">
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

            <div class="product-main">
               <h2 class="title">WISHLIST PRODUK</h2>
               <!-- <h2 class="title">Pesanan</h2> -->
               <div class="product-grid">
                  <!-- <div class="showcase">
                     <div class="showcase-banner"> -->
                  <!-- <section class="dashboard"> -->

                  <!-- <h1 class="heading">dashboard</h1> -->

                  <!-- <div class="box-container"> -->

                  <div class="showcase">
                     <div class="showcase-banner">

                        <?php
                        $total_pendings = 0;
                        $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_pendings->execute(['pending']);
                        if ($select_pendings->rowCount() > 0) {
                           while ($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)) {
                              $total_pendings += $fetch_pendings['total_price'];
                           }
                        }
                        ?>
                       <h3>  <i class="fa-solid fa-box"></i> <span>Rp.</span><?= $total_pendings; ?><span>,00</span></h3>
                        <p>total pesanan</p>
                        <a href="placed_orders.php" class="btn-login">lihat pesanan</a>
                     </div>
                  </div>
                  <div class="showcase">
                     <div class="showcase-banner">
                        <?php
                        $total_completes = 0;
                        $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_completes->execute(['completed']);
                        if ($select_completes->rowCount() > 0) {
                           while ($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)) {
                              $total_completes += $fetch_completes['total_price'];
                           }
                        }
                        ?>
                        <h3><i class="fa-solid fa-box-open"></i> <span>Rp.</span><?= $total_completes; ?><span>,00</span></h3>
                        <p>pesanan selesai</p>
                        <a href="placed_orders.php" class="btn-login">lihat pesanan</a>
                     </div>
                  </div>
                  <div class="showcase">
                     <div class="showcase-banner">
                        <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        $number_of_orders = $select_orders->rowCount()
                        ?>
                        <h3><i class="fa-solid fa-house-chimney"></i> <?= $number_of_orders; ?></h3>
                        <p>alamat pesanan</p>
                        <a href="placed_orders.php" class="btn-login">lihat pesanan</a>
                     </div>
                  </div>
                  <div class="showcase">
                     <div class="showcase-banner">
                        <?php
                        $select_products = $conn->prepare("SELECT * FROM `products`");
                        $select_products->execute();
                        $number_of_products = $select_products->rowCount()
                        ?>
                        <h3><i class="fa-solid fa-boxes-stacked"></i> <?= $number_of_products; ?></h3>
                        <p>produk ditambahkan</p>
                        <a href="products.php" class="btn-login">lihat produk</a>
                     </div>
                  </div>
                  
                  <!-- </div> -->

                  <!-- </section> -->
               </div>
               <!-- </div>
               </div> -->
            </div>
         </div>

      </div>
   </div>










   <?php include '../components/footer.php'; ?>
   <script src="./js/script.js"></script>
   <!--- ionicon link-->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   <script src="https://kit.fontawesome.com/8a136cd674.js" crossorigin="anonymous"></script>
</body>

</html>