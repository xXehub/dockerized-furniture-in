<?php
include 'components/connect.php';
require_once 'midtrans-php-master/Midtrans.php';
// Include the Midtrans configuration
include 'midtrans-config.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
}


if (isset($_POST['order'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = 'midtrans';
    $address = 'Rumah No. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if ($check_cart->rowCount() > 0) {
        try {
            // Generate unique order ID
            $midtrans_order_id = 'ORDER-' . time() . '-' . $user_id;

            // Insert order ke database
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, order_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $midtrans_order_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

            $db_order_id = $conn->lastInsertId();

            // Setup parameter Midtrans
            $params = array(
                'transaction_details' => array(
                    'order_id' => $midtrans_order_id,
                    'gross_amount' => (int) $total_price,
                ),
                'customer_details' => array(
                    'first_name' => $name,
                    'email' => $email,
                    'phone' => $number,
                    'billing_address' => array(
                        'address' => $address
                    ),
                ),
            );

            // Get Snap Payment Page URL
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update order dengan snap token
            $update_token = $conn->prepare("UPDATE `orders` SET snap_token = ? WHERE id = ?");
            $update_token->execute([$snapToken, $db_order_id]);

            // Hapus cart setelah order
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            // Redirect ke halaman pembayaran
            header("Location: payment_page.php?order_id=" . $db_order_id);
            exit();

        } catch (\Exception $e) {
            // Log error dan tampilkan pesan error yang aman
            error_log("Midtrans Error: " . $e->getMessage());
            $message[] = 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.';
        }
    } else {
        $message[] = 'keranjang anda kosong!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Toko Asia Mebel</title>

    <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style_sakkarepmu.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="product-container">
    <div class="container">
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
                                $grand_total = 0;
                                $cart_items[] = '';
                                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                                $select_cart->execute([$user_id]);
                                // gawe ngisi kolom total_product 
                                if ($select_cart->rowCount() > 0) {
                                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                        $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                                        $total_products = implode($cart_items);
                                        $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                                        ?>

                                        <!--  -->
                                        <div class="showcase">
                                            <input type="hidden" name="image" value="<?= $fetch_cart['image']; ?>">
                                            <a href="#" class="showcase-img-box">
                                                <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="Gambar lur" width="75"
                                                    height="75" class="showcase-img">
                                            </a>
                                            <div class="showcase-content">
                                                <a class="showcase-category"> <?= $fetch_cart['name']; ?> <a
                                                        class="showcase-title">
                                                        (<?= 'Rp.' . $fetch_cart['price'] . ',00 x ' . $fetch_cart['quantity']; ?>
                                                        )</a> </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo '<b class="empty">keranjang anda kosong!</b>';
                                }
                                ?>

                                <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                                <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
                                <div class="grand-total">total semua : <span>Rp.<?= $grand_total; ?>,00</span></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>


        <form action="" method="POST">
            <div class="product-box">
                <div class="product-main">
                    <h2 class="title">CHECKOUT</h2>
                    <div class="product-grid">
                        <div class="inputBox">
                            <span>Nama Anda :</span>
                            <input type="text" name="name" placeholder="masukkan nama anda" class="kolom-field"
                                maxlength="20" required>
                        </div>
                        <div class="inputBox">
                            <span>Nomor :</span>
                            <input type="number" name="number" placeholder="masukkan nomor anda" class="kolom-field"
                                min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;"
                                required>
                        </div>
                        <div class="inputBox">
                            <span>Email :</span>
                            <input type="email" name="email" placeholder="enter your email" class="kolom-field"
                                maxlength="50" required>
                        </div>

                        <div class="inputBox">
                            <span>Nomor Rumah :</span>
                            <input type="text" name="flat" placeholder="contoh : 99" class="kolom-field" maxlength="50"
                                required>
                        </div>
                        <div class="inputBox">
                            <span>RT/RW:</span>
                            <input type="text" name="street" placeholder="contoh : Rt.1 rw.1" class="kolom-field"
                                maxlength="50" required>
                        </div>
                        <div class="inputBox">
                            <span>Kecamatan :</span>
                            <input type="text" name="city" placeholder="contoh : menganti" class="kolom-field"
                                maxlength="50" required>
                        </div>
                        <div class="inputBox">
                            <span>Kabupaten :</span>
                            <input type="text" name="state" placeholder="contoh : Gresik" class="kolom-field"
                                maxlength="50" required>
                        </div>
                        <div class="inputBox">
                            <span>Negara :</span>
                            <input type="text" name="country" placeholder="contoh : indonesia" class="kolom-field"
                                maxlength="50" required>
                        </div>
                        <div class="inputBox">
                            <span>Kode Pos :</span>
                            <input type="number" min="0" name="pin_code" placeholder="contoh : 123456" min="0"
                                max="999999" onkeypress="if(this.value.length == 6) return false;" class="kolom-field"
                                required>
                        </div>
                    </div>
                    <input type="submit" name="order" class="btn btn-login <?= ($grand_total > 1) ? '' : 'disabled'; ?>"
                        value="pesan sekarang">
                </div>
            </div>
        </form>
</div>
</div>


    <?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>

</body>


</html>