<?php
// Munkamenet (session) indítása a bejelentkezéshez
session_start();

// Adatbázis kapcsolat betöltése (később ide teszed be az F1-es db.php-t)
require_once('includes/adatbazis.php'); 

// Megnézzük, mit kért a felhasználó (pl. index.php?oldal=kepek)
// Ha nem kért semmit, akkor a 'fooldal' az alapértelmezett
$oldal = isset($_GET['oldal']) ? $_GET['oldal'] : 'fooldal';

// Fejléc és a menü betöltése (minden oldalon ott lesz)
include('views/header.php');

// Útválasztó (A tényleges Front-controller logika)
switch ($oldal) {
    case 'fooldal':
        // Később ide teszed a Youtube/Saját videós html-t
        echo "<h1>A Forma-1 Története (Főoldal)</h1>"; 
        break;
        
    case 'belepes':
        echo "<h1>Belépés / Regisztráció</h1>";
        // Itt lesz a login űrlap
        break;
        
    case 'kilepes':
        // Felhasználó kiléptetése
        session_destroy();
        header("Location: index.php?oldal=fooldal");
        exit;
        
    case 'kepek':
        echo "<h1>Képgaléria</h1>";
        break;
        
    case 'kapcsolat':
        echo "<h1>Kapcsolat űrlap</h1>";
        break;
        
    case 'uzenetek':
        echo "<h1>Beérkezett üzenetek</h1>";
        break;
        
    case 'crud':
        include('views/crud.php');
        break;

    // Itt regisztráljuk be a törlés útvonalát is!
    case 'pilota_torles':
        require_once('models/pilota_model.php');
        if (isset($_GET['id'])) {
            pilota_torles($dbh, $_GET['id']);
        }
        header("Location: index.php?oldal=crud");
        break;

    default:
        // Ha valami hülyeséget ír az URL-be
        echo "<h2>Hiba 404: Az oldal nem található!</h2>";
        break;
}

// Lábjegyzet betöltése (minden oldalon ott lesz)
include('views/footer.php');
?>