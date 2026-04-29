<?php
require_once('models/pilota_model.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
$pilota = ['az' => '', 'nev' => '', 'nem' => 'férfi', 'szuldat' => '', 'nemzet' => ''];

// Ha van ID, akkor szerkesztés módban vagyunk: töltsük be a pilóta adatait
if ($id) {
    $p = get_pilota_by_az($dbh, $id);
    if ($p) {
        $pilota = $p;
    }
}

// Mentés (Hozzáadás vagy Módosítás) feldolgozása
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nev = $_POST['nev'];
    $nem = $_POST['nem'];
    $szuldat = $_POST['szuldat'];
    $nemzet = $_POST['nemzet'];

    if ($id) {
        // Meglévő frissítése
        pilota_modositas($dbh, $id, $nev, $nem, $szuldat, $nemzet);
        uzenet_beallit('A pilóta adatai sikeresen megváltoztak!', 'success');
    } else {
        // Új pilóta beszúrása
        pilota_hozzaadas($dbh, $nev, $nem, $szuldat, $nemzet);
        uzenet_beallit('Új pilóta sikeresen hozzáadva!', 'success');
    }
    
    // Visszairányítás a listához
    header("Location: index.php?oldal=crud");
    exit;
}
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header <?= $id ? 'bg-primary' : 'bg-success' ?> text-white">
                    <h3 class="card-title mb-0"><?= $id ? 'Pilóta adatainak szerkesztése' : 'Új pilóta felvétele' ?></h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Pilóta neve</label>
                            <input type="text" name="nev" class="form-control" value="<?= htmlspecialchars($pilota['nev']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Neme</label>
                            <select name="nem" class="form-control">
                                <option value="férfi" <?= $pilota['nem'] == 'férfi' ? 'selected' : '' ?>>Férfi</option>
                                <option value="nő" <?= $pilota['nem'] == 'nő' ? 'selected' : '' ?>>Nő</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Születési dátum</label>
                            <input type="date" name="szuldat" class="form-control" value="<?= $pilota['szuldat'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nemzetiség</label>
                            <input type="text" name="nemzet" class="form-control" value="<?= htmlspecialchars($pilota['nemzet']) ?>" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?oldal=crud" class="btn btn-secondary">Mégse</a>
                            <button type="submit" class="btn <?= $id ? 'btn-primary' : 'btn-success' ?>">
                                <?= $id ? 'Módosítások mentése' : 'Pilóta hozzáadása' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>