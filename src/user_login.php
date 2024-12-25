<?php
ob_start();
session_start();
include 'components/connect.php';

// Jika user sudah login, ambil user_id dari session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

// Jika form login disubmit
if (isset($_POST['submit'])) {
   $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
   $pass = sha1($_POST['pass']);
   
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   
   if ($select_user->rowCount() > 0) {
       $row = $select_user->fetch(PDO::FETCH_ASSOC);
       $_SESSION['user_id'] = $row['id'];
       $_SESSION['message'] = 'Login berhasil!';
       header('Location: home.php');
       exit();
   } else {
       $_SESSION['error'] = 'Email atau password salah!';
   }
}


// Logout action
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    $_SESSION['message'] = 'Anda telah berhasil keluar!';  // Set logout message
    header('Location: user_login.php');  // Redirect ke halaman login setelah logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawir.In - eCommerce Website</title>
    <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style_sakkarepmu.css">
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
                    <form action="" method="post">
                        <input type="email" name="email" required placeholder="Masukkan email" class="kolom-field">
                        <input type="password" name="pass" required placeholder="Masukkan password" class="kolom-field" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                        <input type="submit" value="Login Sekarang" class="btn btn-login" name="submit">
                        <p>Belum punya akun? <a href="user_register.php" class="login-subtittle">Buat akun</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
    <script>
        <?php if (isset($_SESSION['error'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $_SESSION['error']; ?>',
            });
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>
    <script src="js/script.js"></script>
</body>
</html>
