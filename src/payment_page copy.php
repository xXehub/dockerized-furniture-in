<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
}

// Get order details
if(isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    $get_order = $conn->prepare("SELECT * FROM `orders` WHERE id = ? AND user_id = ?");
    $get_order->execute([$order_id, $user_id]);
    
    if($get_order->rowCount() > 0){
        $order = $get_order->fetch(PDO::FETCH_ASSOC);
        $snap_token = $order['snap_token'];
    } else {
        header('location:orders.php');
        exit();
    }
} else {
    header('location:orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Toko Asia Mebel</title>
    
    <link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style_sakkarepmu.css">
    
    <!-- Include Midtrans Snap JS -->
    <script src="https://app.midtrans.com/snap/snap.js"
            data-client-key="SB-Mid-client-_k4h8RjGIc1A9Uxf8OxiUQld"></script>
</head>
<body>
    
<?php include 'components/user_header.php'; ?>

<section class="payment-page">
    <div class="container" style="max-width: 800px; margin: 20px auto; padding: 20px;">
        <h2 style="margin-bottom: 20px;"><i class="fas fa-credit-card"></i> PEMBAYARAN</h2>
        
        <div class="payment-details" style="background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px;">Detail Pesanan:</h3>
            <p style="margin-bottom: 10px;">Order ID: <?= htmlspecialchars($order['order_id']) ?></p>
            <p style="margin-bottom: 10px;">Total: Rp.<?= number_format($order['total_price'], 2, ',', '.') ?></p>
            <p style="margin-bottom: 20px;">Status: <?= htmlspecialchars($order['payment_status'] ?? 'Pending') ?></p>
            
            <?php if(!isset($order['payment_status']) || $order['payment_status'] == 'pending'): ?>
                <button id="pay-button" style="background-color: #4CAF50; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                    Bayar Sekarang
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger snap popup
        window.snap.pay('<?= $snap_token ?>', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                alert('Pembayaran berhasil!');
                window.location.href = 'order_success.php?order_id=<?= $order_id ?>';
            },
            onPending: function(result){
                /* You may add your own implementation here */
                alert("Pembayaran pending! Silakan selesaikan pembayaran Anda");
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("Pembayaran gagal!");
            },
            onClose: function(){
                /* You may add your own implementation here */
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>

</body>
</html>