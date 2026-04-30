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
    <nav class="navbar navbar-expand-lg f1-navbar mb-4 shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php?oldal=fooldal">🏁 F1 Adatbázis</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Mindenki által látható menüpontok -->
                <li class="nav-item"><a class="nav-link" href="index.php?oldal=fooldal">Főoldal</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?oldal=crud">Pilóták</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?oldal=kepek">Galéria</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?oldal=kapcsolat">Kapcsolat</a></li>
                
                <!-- Csak az Admin által látható menüpontok (Sárga színnel) -->
                <?php if(isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link text-warning" href="index.php?oldal=felhasznalok">Admin: Userek</a></li>
                    <li class="nav-item"><a class="nav-link text-warning" href="index.php?oldal=uzenetek">Admin: Üzenetek</a></li>
                <?php endif; ?>
            </ul>
            <div class="navbar-nav">
                <!-- Bejelentkezés / Kijelentkezés gombok -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span class="navbar-text text-white me-3">Pilóta: <strong><?= htmlspecialchars($_SESSION['user_nev']) ?></strong></span>
                    <a href="index.php?oldal=logout" class="btn btn-outline-light btn-sm mt-1">Boxutca (Kijelentkezés)</a>
                <?php else: ?>
                    <a href="index.php?oldal=login" class="btn btn-f1 btn-sm me-2 mt-1">Bejelentkezés</a>
                    <a href="index.php?oldal=regisztracio" class="btn btn-outline-light btn-sm mt-1">Regisztráció</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
    <hr>