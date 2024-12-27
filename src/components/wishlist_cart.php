<?php
$wishlist_items = [];  

$query = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
$query->execute([$user_id]);
$wishlist_items = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['add_to_wishlist'])) {

   if ($user_id == '') {
      header('location:user_login.php');
   } else {

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

      // Cek apakah barang sudah ada di wishlist
      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$name, $user_id]);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0) {
         $message[] = 'sudah ada di wishlist!';
         $message_icon = 'error'; 
      } elseif ($check_cart_numbers->rowCount() > 0) {
         $message[] = 'sudah ada di keranjang!';
         $message_icon = 'error'; 
      } else {
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
         $message[] = 'ditambahkan ke wishlist!';
         $message_icon = 'success';  
      }

   }

}

if (isset($_POST['add_to_cart'])) {

   if ($user_id == '') {
      header('location:user_login.php');
   } else {

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

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if ($check_cart_numbers->rowCount() > 0) {
         $message['sudah_keranjang'] = 'sudah ada di keranjang!';
         $message_icon = 'error';  
      } else {

         $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
         $check_wishlist_numbers->execute([$name, $user_id]);

         if ($check_wishlist_numbers->rowCount() > 0) {
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$name, $user_id]);
         }

         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'ditambahkan keranjang!';
         $message_icon = 'success'; 
      }

   }

}
?>

<!DOCTYPE html>
<html lang="id">

<body>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.9/dist/sweetalert2.min.js"></script>

<script type="text/javascript">
   <?php if (isset($message)) { ?>
       Swal.fire({
           icon: '<?= isset($message_icon) ? $message_icon : 'success'; ?>',
           title: '<?= implode(', ', $message); ?>',
           showConfirmButton: false,
           timer: 1500
       });
   <?php } ?>
</script>

</body>
</html>
