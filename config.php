<?php
$host = '127.0.0.1'; 
$dbname = 'streamweb';
$username = 'root';
$password = 'Angeell.03'; 
$port = '3306'; 

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>