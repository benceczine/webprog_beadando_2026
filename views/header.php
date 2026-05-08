<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>F1 Projekt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #e9ecef; } /* Világosszürke háttér */
        .f1-red-bg { background-color: #e10600 !important; } /* F1 Piros */
        .nav-link, .navbar-brand { color: white !important; }
        .footer { background-color: #e10600; color: white; padding: 20px 0; margin-top: 50px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg f1-red-bg mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php?oldal=fooldal">F1 ADATBÁZIS</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php?oldal=fooldal">Főoldal</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?oldal=crud">Pilóták</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?oldal=kepek">Galéria</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?oldal=kapcsolat">Kapcsolat</a></li>
                <?php if(isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark" href="index.php?oldal=felhasznalok">ADMIN: USER</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark" href="index.php?oldal=uzenetek">ADMIN: MSG</a></li>
                <?php endif; ?>
            </ul>
            <div class="navbar-nav">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span class="navbar-text text-white me-2">Bejelentkezve: <?= $_SESSION['user_nev'] ?></span>
                    <a href="index.php?oldal=logout" class="btn btn-dark btn-sm">Kilépés</a>
                <?php else: ?>
                    <a href="index.php?oldal=login" class="btn btn-light btn-sm me-2">Belépés</a>
                    <a href="index.php?oldal=regisztracio" class="btn btn-outline-light btn-sm">Regisztráció</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container" style="min-height: 80vh;">
    <?php if(isset($_SESSION['uzenet'])): ?>
        <div class="alert alert-info"><?= $_SESSION['uzenet']['szoveg'] ?></div>
        <?php unset($_SESSION['uzenet']); ?>
    <?php endif; ?>