<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};

if (isset($_POST['delete'])) {
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if (isset($_GET['delete_all'])) {
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

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
   <link rel="stylesheet" href="./assets/css/style_sakkarepmu.css">

   <!--- google font link-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <div class="product-container">
      <div class="container">
         <!-- total barang -->
         <!-- <div class="sidebar  has-scrollbar" data-mobile-menu>
            <div class="product-showcase">
               <h3 class="showcase-heading">TOTAL BARANG</h3>
               <div class="showcase-wrapper">
                  <div class="showcase-container">
                     <?php
                     $grand_total = 0;
                     $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                     $select_cart->execute([$user_id]);
                     if ($select_cart->rowCount() > 0) {
                        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                     ?>

                     <?php
                        }
                     } else {
                        echo '<p class="empty">no products added yet!</p>';
                     }
                     ?>
                     <div class="showcase">
                        <div class="showcase-content">
                           <div class="product-showcase">

                              <p>total semua : <span>Rp.<?= $grand_total; ?>,00</span></p>
                              <a href="shop.php" class="btn btn-wishlist">Lanjut Belanja</a>
                              <a href="cart.php?delete_all" class="btn btn-delete  <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('hapus semua produk?');">Hapus Semua</a>
                              <a href="checkout.php" class="btn btn-wishlist <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Beli Sekarang</a>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div> -->
         <div class="product-box">
            <!--- PRODUCT GRID-->
            <div class="product-main">
               <h2 class="title"><i class="fa-solid fa-cart-shopping"></i> PRODUK DI KERANJANG</h2>
               <div class="product-grid">
                  <?php
                  $grand_total = 0;
                  $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                  $select_cart->execute([$user_id]);
                  if ($select_cart->rowCount() > 0) {
                     while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                        <form action="" method="post" class="box">
                           <div class="showcase">
                              <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">


                              <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="wishlist" width="300" class="product-img">
                              <div class="showcase-content">
                                  <a class="showcase-category">Rp.<?= $fetch_cart['price']; ?>,00</a>
                              <!-- <a class="showcase-category" href="quick_view.php?pid=<?= $fetch_wishlist['id']; ?> "><?= $fetch_product['kategori']; ?></a> -->
                                 <div class="showcase-title"><?= $fetch_cart['name']; ?></div>

                                 <div class="price-box">
                                    <div class="flex-btn">
                                       <div class="price"><span>Rp.<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>,00</span></div>
                                       <!-- <input type="number" name="qty" class="showcase" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>"> -->

                                       <!-- <input type="number" name="qty" class="showcase" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1"> -->
                                       <!-- <button type="submit" class="" ><a class="fas fa-edit" name="update_qty"> </a></button> -->
                                    </div>
                                    <!-- <div class="container"> -->


                                 </div>



                                 <div class="product ">

                                 </div>

                                 <!-- <div class="showcase-title"> sub total : <span>Rp.<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>,00</span> </div> -->
                                 <!-- <button type="submit" class="fas fa-edit" name="update_qty"></button> -->
                                 <div class="inputBox">
                                    <!-- <button type="submit" class="fas fa-edit" name="update_qty"></button> -->

                                    <!-- <button type="submit" class="showcase"><a class="fas fa-edit" name="update_qty"> </a></button> -->

                                 </div>
                                 <div class="price-box">
                                    <input type="number" name="qty" class="showcase" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
                                    <button type="submit" value="perbarui" class="btn btn-wishlist" name="update_qty"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <!-- <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="btn btn-delete" onclick="return confirm('hapus pesanan ini?');"><i class="fa-solid fa-trash"></i></a> -->
                                    <button type="submit" name="delete" value="hapus item" onclick="return confirm('delete this from cart?');" class="btn btn-delete"><i class="fa-solid fa-trash"></i></button>
                                 </div>
                              </div>
                           </div>

                        </form>

                  <?php
                        $grand_total += $sub_total;
                     }
                  } else {
                     echo '<p class="empty">keranjang anda kosong</p>';
                  }
                  ?>


               </div>

            </div>
         </div>
         <div class="sidebar  has-scrollbar" data-mobile-menu>
            <div class="product-showcase">
               <h3 class="showcase-heading"><i class="fa-solid fa-money-check-dollar"></i> TOTAL BARANG</h3>
               <div class="showcase-wrapper">
                  <div class="showcase-container">
                     <div class="showcase">
                        <div class="showcase-content">
                           <div class="product-showcase">

                              <p>total semua : <span>Rp.<?= $grand_total; ?>,00</span></p>

                              <a href="shop.php" class="btn btn-wishlist">Lanjut Belanja</ion-icon></a>
                              <a href="cart.php?delete_all" class="btn btn-delete  <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('hapus semua produk?');">Hapus Semua</a>
                              <a href="checkout.php" class="btn btn-wishlist <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="fa-solid fa-money-check-dollar"></i> Beli Sekarang</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="cart-total">


   </div>

   </section>
   <?php include 'components/footer.php'; ?>
   <!-- jawir script -->
   <script src="js/script.js"></script>
   <!-- ion icon -->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   <script src="https://kit.fontawesome.com/8a136cd674.js" crossorigin="anonymous"></script>
</body>

</html>