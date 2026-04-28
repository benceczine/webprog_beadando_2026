<?php

$host = 'localhost';
$dbname = 'forma1';
$user = 'root';
$pass = '';    

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Hibaüzenetek bekapcsolása fejlesztéshez
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Adatbázis hiba: " . $e->getMessage());
}
?>