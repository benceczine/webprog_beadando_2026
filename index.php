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
        
    case 'login':
        include('views/login.php');
        break;

    case 'login_ellenorzes':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $_POST['user'];
            $pass = $_POST['pass'];

            $stmt = $dbh->prepare("SELECT * FROM felhasznalok WHERE felhasznalonev = ? AND jelszo = ?");
            $stmt->execute([$user, $pass]);
            $felhasznalo = $stmt->fetch();

            if ($felhasznalo) {
                $_SESSION['user_id'] = $felhasznalo['id'];
                $_SESSION['user_nev'] = $felhasznalo['felhasznalonev'];
                header("Location: index.php?oldal=fooldal");
            } else {
                echo "<script>alert('Hibás adatok!'); window.location.href='index.php?oldal=login';</script>";
            }
        }
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php?oldal=fooldal");
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
        include('views/kapcsolat.php');
        break;

    case 'kapcsolat_mentes':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nev = $_POST['nev'];
            $email = $_POST['email'];
            $uzenet = $_POST['uzenet'];

            $stmt = $dbh->prepare("INSERT INTO uzenetek (nev, email, uzenet) VALUES (?, ?, ?)");
            $stmt->execute([$nev, $email, $uzenet]);
            
            echo "<script>alert('Üzenet elküldve!'); window.location.href='index.php?oldal=fooldal';</script>";
        }
        break;
        
    case 'uzenetek':
        echo "<h1>Beérkezett üzenetek</h1>";
        break;
        
    case 'crud':
        include('views/crud.php');
        break;

    // Itt regisztráljuk be a törlés útvonalát is!
    case 'pilota_torles':
        // Csak bejelentkezett felhasználó törölhet!
        if (!isset($_SESSION['user_id'])) {
            die("Ehhez a művelethez be kell jelentkezned!");
        }
        require_once('models/pilota_model.php');
        if (isset($_GET['id'])) {
            pilota_torles($dbh, $_GET['id']);
        }
        header("Location: index.php?oldal=crud");
        break;
}

// Lábjegyzet betöltése (minden oldalon ott lesz)
include('views/footer.php');
?>