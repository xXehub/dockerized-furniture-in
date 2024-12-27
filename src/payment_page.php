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
    <title>Payment - Jawir.In</title>
    
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
        window.snap.pay('<?= $snap_token ?>', {
            onSuccess: function(result){
                // Update local status immediately
                updatePaymentStatus('<?= $order['id'] ?>', 'completed', result);
            },
            onPending: function(result){
                // Keep status as pending
                alert("Pembayaran pending! Silakan selesaikan pembayaran Anda");
            },
            onError: function(result){
                // Update status to cancelled on error
                updatePaymentStatus('<?= $order['id'] ?>', 'cancelled', result);
            },
            onClose: function(){
                // Check status when popup is closed
                checkPaymentStatus('<?= $order['id'] ?>');
            }
        });
    });

    function updatePaymentStatus(orderId, status, result) {
        fetch('update_payment_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                status: status,
                payment_data: result
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                window.location.href = 'orders.php';
            } else {
                alert('Terjadi kesalahan saat memperbarui status pembayaran');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function checkPaymentStatus(orderId) {
        fetch('check_payment_status.php?order_id=' + orderId)
        .then(response => response.json())
        .then(data => {
            if(data.status === 'completed') {
                window.location.href = 'orders.php';
            } else if(data.status === 'cancelled') {
                alert('Pembayaran dibatalkan atau kedaluwarsa');
                window.location.href = 'orders.php';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

</body>
</html>