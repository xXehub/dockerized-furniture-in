<?php
// Contoh pengambilan data dari database atau array
$wishlist_items = [];  // Ini harus array

// Kalau ambil data dari database, pastikan fetchAll() digunakan agar hasilnya array
$query = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
$query->execute([$user_id]);
$wishlist_items = $query->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['add_to_wishlist'])) {

   if ($user_id == '') {
      header('location:user_login.php');
   } else {

      // Sanitize input using htmlspecialchars instead of FILTER_SANITIZE_STRING
      $pid = $_POST['pid'];
      $pid = htmlspecialchars($pid, ENT_QUOTES, 'UTF-8');

      $name = $_POST['name'];
      $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

      $price = $_POST['price'];
      $price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');

      $image = $_POST['image'];
      $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');

      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);


      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$name, $user_id]);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0) {
         $message[] = 'already added to wishlist!';
      } elseif ($check_cart_numbers->rowCount() > 0) {
         $message[] = 'already added to cart!';
      } else {
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
         $message[] = 'added to wishlist!';
      }

   }

}

if (isset($_POST['add_to_cart'])) {

   if ($user_id == '') {
      header('location:user_login.php');
   } else {

      // Sanitize input using htmlspecialchars instead of FILTER_SANITIZE_STRING
      $pid = $_POST['pid'];
      $pid = htmlspecialchars($pid, ENT_QUOTES, 'UTF-8');

      $name = $_POST['name'];
      $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

      $price = $_POST['price'];
      $price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');

      $image = $_POST['image'];
      $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');

      // For quantity, if it's expected to be a numeric value, use a filter for integers
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_NUMBER_INT);


      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if ($check_cart_numbers->rowCount() > 0) {
         $message['sudah_keranjang'] = 'already added to cart!';
      } else {

         $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
         $check_wishlist_numbers->execute([$name, $user_id]);

         if ($check_wishlist_numbers->rowCount() > 0) {
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$name, $user_id]);
         }

         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'added to cart!';

      }

   }

}

?>