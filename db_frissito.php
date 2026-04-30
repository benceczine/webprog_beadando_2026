<?php
require_once('includes/adatbazis.php');

// 1. Új oszlop a felhasználóknak (alapértelmezetten 0, azaz nincs joguk)
try {
    $dbh->exec("ALTER TABLE felhasznalok ADD COLUMN kep_engedely TINYINT(1) DEFAULT 0");
} catch(PDOException $e) {
    // Ha az oszlop már létezik, csendben továbbmegyünk
}

// 2. Létrehozzuk a galéria táblát a feltöltött képek adatainak
try {
    $dbh->exec("CREATE TABLE IF NOT EXISTS galeria (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fajlnev VARCHAR(255) NOT NULL,
        feltolto_nev VARCHAR(100) NOT NULL
    )");
    echo "<h2 style='color:green;'>Szuper! Az adatbázis felkészült a képfeltöltésre!</h2>";
    echo "<p>Ezt a db_frissito.php fájlt most már letörölheted.</p>";
} catch(PDOException $e) {
    echo "Hiba történt: " . $e->getMessage();
}
?>