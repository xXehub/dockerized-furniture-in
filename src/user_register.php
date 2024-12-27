<?php
include 'components/connect.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
   $name = htmlspecialchars($_POST['name']);
   $email = htmlspecialchars($_POST['email']);
   $pass = sha1($_POST['pass']);
   $cpass = sha1($_POST['cpass']);
   $address = htmlspecialchars($_POST['address']); // Tambahkan ini

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($select_user->rowCount() > 0) {
      $_SESSION['duplikat'] = 'Email sudah terdaftar!';
   } else {
      if ($pass != $cpass) {
         $_SESSION['error'] = 'Konfirmasi password tidak sama!';
      } else {
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password, address) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $cpass, $address]);
         $_SESSION['register_berhasil'] = 'Buat akun sukses, login sekarang!';
      }
   }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style_sakkarepmu.css">

    <!-- google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <?php include 'components/user_header.php'; ?>
    <div class="login">
        <div class="container">
            <div class="slider-item">
                <div class="login-content">
                    <section class="form-container">
                        <form action="" method="post">
                        <input type="text" name="name" required placeholder="Masukkan username" maxlength="20" class="kolom-field">
   <input type="email" name="email" required placeholder="Masukkan email" maxlength="50" class="kolom-field" oninput="this.value = this.value.replace(/\s/g, '')">
   <input type="password" name="pass" required placeholder="Masukkan password" maxlength="20" class="kolom-field" oninput="this.value = this.value.replace(/\s/g, '')">
   <input type="password" name="cpass" required placeholder="Konfirmasi password" maxlength="20" class="kolom-field" oninput="this.value = this.value.replace(/\s/g, '')">
   <input type="text" name="address" required placeholder="Masukkan alamat" maxlength="255" class="kolom-field">
   <input type="text" name="phone" required placeholder="Masukkan nomor telepon" maxlength="15" class="kolom-field">

                            <!-- Notifikasi -->
                            <p style="color:red;">
                                <?php
                                if (isset($_SESSION['error'])) {
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                }
                                ?>
                            </p>
                            <p style="color:red;">
                                <?php
                                if (isset($_SESSION['duplikat'])) {
                                    echo $_SESSION['duplikat'];
                                    unset($_SESSION['duplikat']);
                                }
                                ?>
                            </p>
                            <p style="color:green;">
                                <?php
                                if (isset($_SESSION['register_berhasil'])) {
                                    echo $_SESSION['register_berhasil'];
                                    unset($_SESSION['register_berhasil']);
                                }
                                ?>
                            </p>

                            <input type="submit" value="Daftar Sekarang" class="btn btn-login" name="submit">
                            <p>Sudah punya akun?</p>
                            <a class="login-subtittle" href="user_login.php" class="option-btn">Login Sekarang</a>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <script src="js/script.js"></script>
</body>

</html>
