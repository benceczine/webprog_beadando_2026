<?php
// models/kapcsolat_mentes.php
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nev = trim($_POST['nev']);
    $email = trim($_POST['email']);
    $uzenet = trim($_POST['uzenet']);

    // Szerveroldali ellenőrzés 
    if (empty($nev) || empty($email) || empty($uzenet)) {
        die("Minden mező kitöltése kötelező!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Érvénytelen e-mail cím!");
    }

    // Mentés az adatbázisba 
    $stmt = $dbh->prepare("INSERT INTO uzenetek (nev, email, uzenet) VALUES (?, ?, ?)");
    $stmt->execute([$nev, $email, $uzenet]);

    echo "Üzenet sikeresen elküldve!";
}
?>