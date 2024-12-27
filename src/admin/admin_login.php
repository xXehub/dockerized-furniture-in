<?php
ob_start();
session_start();
include '../components/connect.php';

if (isset($_POST['submit'])) {
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   
   if ($select_admin->rowCount() > 0) {
      $row = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $row['id'];
      header('Location: dashboard.php');
      exit();
   } else {
      $message[] = 'incorrect username or password!';
   }
}

// Rest of your HTML code remains the same
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!--- css link lur, eksternal btw-->
   <link rel="stylesheet" href="../assets/css/style_sakkarepmu.css">

   <!--- google font link-->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>
 
   <!-- login baru -->
   <div class="login">
      <div class="container">

         <div class="slider-item">
            
            <!-- <img src="./assets/images/Quirky-house-Banner.jpg" alt="women's latest fashion sale" class="banner-img"> -->
            <div class="login-content">
               
               <h2 class="banner-title">Jawir Admins.</h2>

               <form action="" method="post">

                  <!-- <h3 class="login-text">Login Sekarang</h3> -->
                  <input type="text" name="name" required placeholder="masukkann username" class="kolom-field">
                  <input type="password" name="pass" required placeholder="masukkan password" class="kolom-field" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">

                  <p style="color:red;">
                     <?php
                     if (isset($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                     }
                     ?>
                  </p>
                  <input type="submit" value="login sekarang" class="btn btn-login" name="submit">
                  <p>tidak punya akun?<a href="user_register.php" class="login-subtittle">buat akun</a></p>

               </form>
            </div>
         </div>
         <!-- <div class="alert">   
                     <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            This is an alert box.
         </div> -->
      </div>
   </div>
   <!-- 
<section class="form-container">

   <form action="" method="post">
      <h3>login sekarang</h3>
      <p>default username = <span>admin</span> & password = <span>111</span></p>
      <input type="text" name="name" required placeholder="masukkan username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="masukkan password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login sekarang" class="btn" name="submit">
   </form>

</section> -->

</body>

</html>