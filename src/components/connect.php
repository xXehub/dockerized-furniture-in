<?php
$db_name = 'mysql:host=mysql_db;dbname=furniture_sakkarepmu;port=3306';
$user_name = 'root';
$user_password = 'parkiranbanjir';

try {
    $conn = new PDO($db_name, $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>