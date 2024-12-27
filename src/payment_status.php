<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id']) && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $payment_type = $_POST['payment_type'] ?? '';
    
    try {
        $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ?, payment_type = ? WHERE id = ? AND user_id = ?");
        $update_payment->execute([$status, $payment_type, $order_id, $_SESSION['user_id']]);
        
        echo json_encode(['success' => true]);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}