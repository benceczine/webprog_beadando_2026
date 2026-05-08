<?php
// 1. Adatok lekérése a te oszlopneveid alapján (az, nem, nemzet, nev, szuldat)
$kereses = isset($_GET['kereses']) ? trim($_GET['kereses']) : '';

if ($kereses !== '') {
    // Keresés a 'nev' oszlopban
    $stmt = $dbh->prepare("SELECT * FROM pilotak WHERE nev LIKE ? ORDER BY nev ASC");
    $stmt->execute(["%$kereses%"]);
} else {
    // Összes lekérése
    $stmt = $dbh->query("SELECT * FROM pilotak ORDER BY nev ASC");
}
$pilotak = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card p-4 shadow-sm border-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Pilóták listája</h3>
        <?php if(isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin'): ?>
            <a href="index.php?oldal=pilota_hozzaadas" class="btn btn-success fw-bold">Új pilóta +</a>
        <?php endif; ?>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <input type="hidden" name="oldal" value="crud">
        <div class="col-auto">
            <input type="text" name="kereses" class="form-control" placeholder="Név keresése..." value="<?= htmlspecialchars($kereses) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary fw-bold">Keresés</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Név</th>
                    <th>Nemzetiség</th>
                    <th>Születési dátum</th>
                    <?php if(isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin'): ?>
                        <th class="text-center">Műveletek</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pilotak) > 0): ?>
                    <?php foreach($pilotak as $p): ?>
                    <tr>
                        <td class="fw-bold"><?= htmlspecialchars($p['nev']) ?></td>
                        <td><?= htmlspecialchars($p['nemzet']) ?></td>
                        <td><?= htmlspecialchars($p['szuldat']) ?></td>
                        
                        <?php if(isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin'): ?>
                        <td class="text-center">
                            <a href="index.php?oldal=pilota_szerkesztes&id=<?= $p['az'] ?>" class="btn btn-sm btn-warning fw-bold">Szerkeszt</a>
                            <a href="index.php?oldal=pilota_torles&id=<?= $p['az'] ?>" class="btn btn-sm btn-danger fw-bold" onclick="return confirm('Biztosan törlöd?')">Töröl</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted">Nincs találat.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>