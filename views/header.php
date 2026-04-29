<?php if (isset($_SESSION['uzenet'])): ?>
    <div class="alert alert-<?= $_SESSION['uzenet']['tipus'] ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['uzenet']['szoveg'] ?>
        <?php unset($_SESSION['uzenet']); // Megjelenítés után töröljük ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>F1 Backend Teszt</title>
</head>
<body>
    <nav>
        <a href="index.php?oldal=fooldal">Főoldal</a> | 
        <a href="index.php?oldal=crud">CRUD (Pilóták)</a> | 
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <span style="margin-left: 15px;">Üdv, <strong><?= htmlspecialchars($_SESSION['user_nev']) ?></strong>!</span> |
            <a href="index.php?oldal=logout" style="color: red; font-weight: bold;">Kijelentkezés</a>
        <?php else: ?>
            <a href="index.php?oldal=login" style="color: blue; font-weight: bold;">Bejelentkezés</a> | 
            <a href="index.php?oldal=regisztracio" style="color: green; font-weight: bold;">Regisztráció</a>
        <?php endif; ?>
        <?php if(isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin'): ?>
            | <a href="index.php?oldal=felhasznalok" style="color: purple; font-weight: bold;">Felhasználók kezelése</a> 
        <?php endif; ?>
        </nav>
    <hr>