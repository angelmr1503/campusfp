<?php
$host = 'localhost'; 
$dbname = 'streamweb';
$username = 'root';
$password = 'curso'; 
$port = '3306'; 

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
