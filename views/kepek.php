<?php
// Lekérdezzük az összes eddig feltöltött képet (a legújabbak lesznek elöl)
$stmt = $dbh->query("SELECT * FROM galeria ORDER BY id DESC");
$kepek = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Jogosultság ellenőrzése: Admin-e, vagy kapott-e jogot?
$jogosult = false;
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_nev'] === 'admin') {
        $jogosult = true;
    } else {
        // Megnézzük az adatbázisban a kep_engedely oszlopot
        $stmt_jog = $dbh->prepare("SELECT kep_engedely FROM felhasznalok WHERE id = ?");
        $stmt_jog->execute([$_SESSION['user_id']]);
        $user_jog = $stmt_jog->fetch();
        if ($user_jog && $user_jog['kep_engedely'] == 1) {
            $jogosult = true;
        }
    }
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Forma-1 Képgaléria</h2>

    <!-- Fájlfeltöltő űrlap: CSAK JOGOSULTAKNAK -->
    <?php if ($jogosult): ?>
        <div class="card shadow-sm border-0 mb-5" style="background-color: #f8f9fa; border-left: 5px solid var(--f1-red) !important;">
            <div class="card-body">
                <h5 style="color: var(--f1-red);">Új kép feltöltése a Boxutcából 📸</h5>
                <form action="index.php?oldal=kep_feltoltes" method="POST" enctype="multipart/form-data" class="row g-3 align-items-center mt-2">
                    <div class="col-md-8">
                        <input class="form-control" type="file" name="kep" accept="image/jpeg, image/png, image/webp" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-f1 w-100">Feltöltés!</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- Feltöltött képek rácsa -->
    <div class="row g-4">
        <?php if (count($kepek) > 0): ?>
            <?php foreach ($kepek as $kep): ?>
                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php if (count($kepek) > 0): ?>
        <?php foreach ($kepek as $kep): ?>
            <div style="border: 1px solid #ccc; padding: 10px; text-align: center; background-color: white;">
                <img src="uploads/<?= htmlspecialchars($kep['fajlnev']) ?>" alt="F1 Kép" style="max-width: 250px; display: block; margin-bottom: 10px;">
                <small>Feltöltötte: <strong><?= htmlspecialchars($kep['feltolto_nev']) ?></strong></small>
                
                <br>
                
                <!-- TÖRLÉS GOMB: Csak az Adminnak jelenik meg -->
                <?php if (isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin'): ?>
                    <div style="margin-top: 10px;">
                        <!-- A JavaScript confirm() dob fel egy kis megerősítő ablakot, nehogy véletlenül kattintsunk rá -->
                        <a href="index.php?oldal=kep_torles&id=<?= $kep['id'] ?>" 
                           style="color: red; text-decoration: none; font-weight: bold; font-size: 14px;"
                           onclick="return confirm('Biztosan törölni akarod ezt a képet véglegesen?');">
                           🗑️ Kép törlése
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Még senki nem töltött fel képet a Boxutcából.</p>
    <?php endif; ?>
</div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="lead">Még senki nem töltött fel képet. Légy te az első!</p>
            </div>
        <?php endif; ?>
    </div>
</div>