<?php
// Adatok lekérése
$stmt = $dbh->query("SELECT * FROM galeria ORDER BY id DESC");
$kepek = $stmt->fetchAll(PDO::FETCH_ASSOC);

$jogosult = false;
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_nev'] === 'admin') { $jogosult = true; } 
    else {
        $stmt_j = $dbh->prepare("SELECT kep_engedely FROM felhasznalok WHERE id = ?");
        $stmt_j->execute([$_SESSION['user_id']]);
        $u = $stmt_j->fetch();
        if ($u && $u['kep_engedely'] == 1) $jogosult = true;
    }
}
?>

<div class="card p-4">
    <h3>Képgaléria</h3>

    <?php if ($jogosult): ?>
        <div class="border p-3 mb-4 bg-light">
            <p><strong>Új kép feltöltése:</strong></p>
            <form action="index.php?oldal=kep_feltoltes" method="POST" enctype="multipart/form-data">
                <input type="file" name="kep" class="form-control mb-2" required>
                <button type="submit" class="btn btn-primary">Feltöltés gomb</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($kepek as $k): ?>
            <div class="col-md-4 mb-3">
                <div class="card p-2 text-center">
                    <img src="uploads/<?= $k['fajlnev'] ?>" class="img-fluid border mb-2">
                    <small>Feltöltő: <?= $k['feltolto_nev'] ?></small>
                    <?php if (isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin'): ?>
                        <a href="index.php?oldal=kep_torles&id=<?= $k['id'] ?>" class="btn btn-sm btn-outline-danger mt-2">Kép törlése</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>