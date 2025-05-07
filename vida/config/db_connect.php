<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vida_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8mb4");
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
