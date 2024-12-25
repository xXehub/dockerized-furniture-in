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

   <?php include '../components/admin_header.php'; ?>
   <div class="product-container">
      <div class="container">
         <!--  -->
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
         <!--  -->
         <div class="product-kolom-field">
            <div class="product-main">
            <h2 class="title">Tambah Produk</h2>
               <section class="add-products">

   

                  <form action="" method="post" enctype="multipart/form-data">
                     <div class="">
                     <div class="product-grid">
                        <div class="inputBox">
                           <span>nama produk :</span>
                           <input type="text" class="kolom-field" required maxlength="100" placeholder="nama produk" name="name">
                        </div>

                        <div class="inputBox">
                           <span>harga produk:</span>
                           <input type="number" min="0" class="kolom-field" required max="9999999999" placeholder="harga" onkeypress="if(this.value.length == 10) return false;" name="price">
                        </div>
                        <div class="inputBox">
                           <span>Kategori :</span>
                           <select name="kategori" class="kolom-field" required>
                              <option value="Tempat Tidur">Tempat Tidur</option>
                              <option value="Sofa Set">Sofa Set</option>
                           </select>
                        </div>
                     </div>

                     <!--  -->
                     <div class="product-grid">
                        <div class="inputBox">
                           <span>image 01 (required)</span>
                           <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom-field" required>
                        </div>
                        <div class="inputBox">
                           <span>image 02 (required)</span>
                           <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom-field" required>
                        </div>
                        <div class="inputBox">
                           <span>image 03 (required)</span>
                           <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="kolom-field" required>
                        </div>
                     </div>
                        <div class="inputBox">
                           <!-- <span>detail produk </span> -->
                           <textarea name="details" placeholder="masukkan detail produk" class="kolom-field" required maxlength="500" cols="30" rows="10"></textarea>
                        </div>
                     </div>

                     <input type="submit" value="tambah produk" class="btn-login" name="add_product">
                  </form>

               </section>
            </div>
         </div>
<!--  -->
       



      </div>
   </div>

   <?php include '../components/footer.php'; ?>

   <script src="../js/admin_script.js"></script>

</body>

</html>