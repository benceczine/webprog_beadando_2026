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
        <a href="index.php?oldal=crud">CRUD (Pilóták)</a>
    </nav>
    <hr>

