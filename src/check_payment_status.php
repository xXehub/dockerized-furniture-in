<?php
include 'components/connect.php';
session_start();

header('Content-Type: application/json');

if (!isset($_GET['order_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing order_id parameter']);
    exit;
}

$order_id = $_GET['order_id'];

try {
    $stmt = $conn->prepare("SELECT payment_status FROM `orders` WHERE id = ?");
    $stmt->execute([$order_id]);
    
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => $result['payment_status']]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Order not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?>