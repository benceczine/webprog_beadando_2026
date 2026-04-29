<?php
// Behúzzuk az adatbázis kapcsolatot
require_once('includes/adatbazis.php');

// 1. Letöröljük a régi, esetleg hibás admin fiókot (ha létezik)
$dbh->query("DELETE FROM felhasznalok WHERE felhasznalonev = 'admin'");

// 2. Legeneráljuk a biztonságos jelszót
$jelszo_tisztan = 'admin123';
$jelszo_titkositva = password_hash($jelszo_tisztan, PASSWORD_DEFAULT);

// 3. Beszúrjuk az új admint az adatbázisba
$stmt = $dbh->prepare("INSERT INTO felhasznalok (felhasznalonev, jelszo) VALUES ('admin', ?)");
$stmt->execute([$jelszo_titkositva]);

echo "<h2 style='color: green;'>Szuper! Az admin fiók sikeresen létrejött!</h2>";
echo "<p>Most már visszamehetsz a weboldalra, és be tudsz lépni az <strong>admin</strong> / <strong>admin123</strong> párossal.</p>";
echo "<p><em>(Ezt az admin_keszito.php fájlt most már letörölheted a VS Code-ban!)</em></p>";
?>