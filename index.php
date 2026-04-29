<?php
session_start();
function uzenet_beallit($szoveg, $tipus = 'success') {
    $_SESSION['uzenet'] = ['szoveg' => $szoveg, 'tipus' => $tipus];
}

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
        
    case 'regisztracio':
        include('views/regisztracio.php');
        break;

    case 'regisztracio_mentes':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = trim($_POST['user']);
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];

            // 1. Biztonság: Egyezik-e a két jelszó?
            if ($pass !== $pass2) {
                uzenet_beallit('A két jelszó nem egyezik!', 'danger');
                header("Location: index.php?oldal=regisztracio");
                exit;
            }

            // 2. Biztonság: Foglalt-e már a felhasználónév?
            $stmt = $dbh->prepare("SELECT id FROM felhasznalok WHERE felhasznalonev = ?");
            $stmt->execute([$user]);
            if ($stmt->fetch()) {
                uzenet_beallit('Ez a felhasználónév már foglalt, válassz másikat!', 'warning');
                header("Location: index.php?oldal=regisztracio");
                exit;
            }

            // 3. Mentés: Jelszó titkosítása és adatbázisba írás
            $titkositott_jelszo = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $dbh->prepare("INSERT INTO felhasznalok (felhasznalonev, jelszo) VALUES (?, ?)");
            $stmt->execute([$user, $titkositott_jelszo]);

            // Siker esetén átirányítjuk a login oldalra
            uzenet_beallit('Sikeres regisztráció! Most már beléphetsz.', 'success');
            header("Location: index.php?oldal=login");
            exit;
        }
        break;
    
    case 'login':
        include('views/login.php');
        break;
    
    case 'login_ellenorzes':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $_POST['user'];
            $pass = $_POST['pass'];

            // Csak felhasználónév alapján keresünk
            $stmt = $dbh->prepare("SELECT * FROM felhasznalok WHERE felhasznalonev = ?");
            $stmt->execute([$user]);
            $felhasznalo = $stmt->fetch();

            // A PHP ellenőrzi a titkosított jelszót
            if ($felhasznalo && password_verify($pass, $felhasznalo['jelszo'])) {
                $_SESSION['user_id'] = $felhasznalo['id'];
                $_SESSION['user_nev'] = $felhasznalo['felhasznalonev'];
                header("Location: index.php?oldal=fooldal");
            } else {
                echo "<script>alert('Hibás felhasználónév vagy jelszó!'); window.location.href='index.php?oldal=login';</script>";
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
        // Védelem: Csak az 'admin' nevű felhasználó törölhet!
        if (!isset($_SESSION['user_id']) || $_SESSION['user_nev'] !== 'admin') {
            uzenet_beallit('Nincs jogosultságod a pilóták törléséhez!', 'danger');
            header("Location: index.php?oldal=crud");
            exit; // Fontos, hogy itt megállítsuk a futást!
        }
        
        require_once('models/pilota_model.php');
        if (isset($_GET['id'])) {
            pilota_torles($dbh, $_GET['id']);
            // Visszajelzés a sikeres törlésről
            uzenet_beallit('A pilóta sikeresen törölve!', 'success');
        }
        header("Location: index.php?oldal=crud");
        break;

    case 'pilota_hozzaadas':
    case 'pilota_szerkesztes':
        // Védelem: Csak az 'admin' nevű felhasználó szerkeszthet!
        if (!isset($_SESSION['user_id']) || $_SESSION['user_nev'] !== 'admin') {
            uzenet_beallit('Csak az adminisztrátor adhat hozzá vagy szerkeszthet pilótákat!', 'danger');
            header("Location: index.php?oldal=crud");
            exit; // Megállítjuk a futást, hogy ne töltse be az űrlapot
        }
        include('views/pilota_szerkesztes.php');
        break;
    case 'felhasznalok':
        // Védelem: Csak az admin láthatja ezt az oldalt!
        if (!isset($_SESSION['user_id']) || $_SESSION['user_nev'] !== 'admin') {
            uzenet_beallit('Nincs jogosultságod megtekinteni ezt az oldalt!', 'danger');
            header("Location: index.php?oldal=fooldal");
            exit;
        }
        include('views/felhasznalok.php');
        break;

    case 'felhasznalo_torles':
        // Védelem: Csak az admin törölhet!
        if (!isset($_SESSION['user_id']) || $_SESSION['user_nev'] !== 'admin') {
            uzenet_beallit('Nincs jogosultságod a művelethez!', 'danger');
            header("Location: index.php?oldal=fooldal");
            exit;
        }

        if (isset($_GET['id'])) {
            $torlendo_id = $_GET['id'];
            
            // Lekérjük a törlendő usert, hogy ellenőrizzük, nem az admin-e az
            $stmt = $dbh->prepare("SELECT felhasznalonev FROM felhasznalok WHERE id = ?");
            $stmt->execute([$torlendo_id]);
            $user = $stmt->fetch();
            
            if ($user && $user['felhasznalonev'] !== 'admin') {
                $del_stmt = $dbh->prepare("DELETE FROM felhasznalok WHERE id = ?");
                $del_stmt->execute([$torlendo_id]);
                uzenet_beallit('A felhasználó sikeresen törölve!', 'success');
            } else {
                uzenet_beallit('Ezt a felhasználót nem lehet törölni!', 'danger');
            }
        }
        header("Location: index.php?oldal=felhasznalok");
        break;
    case 'admin_felhasznalo_hozzaadas':
        // Védelem: Csak admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_nev'] !== 'admin') {
            header("Location: index.php?oldal=fooldal");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = trim($_POST['user']);
            $pass = $_POST['pass'];
            
            // Foglaltság ellenőrzése
            $stmt = $dbh->prepare("SELECT id FROM felhasznalok WHERE felhasznalonev = ?");
            $stmt->execute([$user]);
            if ($stmt->fetch()) {
                uzenet_beallit('Ez a név már foglalt!', 'danger');
            } else {
                $titkositott = password_hash($pass, PASSWORD_DEFAULT);
                $ins = $dbh->prepare("INSERT INTO felhasznalok (felhasznalonev, jelszo) VALUES (?, ?)");
                $ins->execute([$user, $titkositott]);
                uzenet_beallit('Új felhasználó sikeresen hozzáadva!', 'success');
            }
        }
        header("Location: index.php?oldal=felhasznalok");
        break;

    case 'felhasznalo_jelszo':
        // Védelem: Csak admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_nev'] !== 'admin') {
            header("Location: index.php?oldal=fooldal");
            exit;
        }
        include('views/felhasznalo_jelszo.php');
        break;

    case 'admin_jelszo_mentes':
        // Védelem: Csak admin
        if (!isset($_SESSION['user_id']) || $_SESSION['user_nev'] !== 'admin') {
            header("Location: index.php?oldal=fooldal");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $uj_jelszo = $_POST['uj_jelszo'];
            
            $titkositott = password_hash($uj_jelszo, PASSWORD_DEFAULT);
            $stmt = $dbh->prepare("UPDATE felhasznalok SET jelszo = ? WHERE id = ?");
            $stmt->execute([$titkositott, $id]);
            
            uzenet_beallit('A jelszó sikeresen módosítva!', 'success');
        }
        header("Location: index.php?oldal=felhasznalok");
        break;
}

// Lábjegyzet betöltése (minden oldalon ott lesz)
include('views/footer.php');
?>