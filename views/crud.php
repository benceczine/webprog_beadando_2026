<?php
require_once('models/pilota_model.php');

$kereses = isset($_GET['kereses']) ? $_GET['kereses'] : '';
$pilotak = get_szurt_pilotak($dbh, $kereses);

// Létrehozunk egy kényelmes változót, hogy tudjuk, admin-e az illető
$is_admin = (isset($_SESSION['user_nev']) && $_SESSION['user_nev'] === 'admin');
?>

<div class="container">
    <h2 class="text-center my-4">Pilóták kezelése</h2>

    <form action="index.php" method="GET" class="mb-3 d-flex" style="max-width: 400px;">
        <input type="hidden" name="oldal" value="crud">
        <input type="text" name="kereses" class="form-control me-2" placeholder="Keresés névre..." value="<?= htmlspecialchars($kereses) ?>">
        <button type="submit" class="btn btn-outline-primary">Keresés</button>
        
        <?php if ($kereses !== ''): ?>
            <a href="index.php?oldal=crud" class="btn btn-outline-secondary ms-2">Törlés</a>
        <?php endif; ?>
    </form>

    <?php if ($is_admin): ?>
        <a href="index.php?oldal=pilota_hozzaadas" class="btn btn-success mb-3">Új pilóta felvétele</a>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Nem</th>
                <th>Születési dátum</th>
                <th>Nemzet</th>
                <?php if ($is_admin): ?>
                    <th>Műveletek</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pilotak) > 0): ?>
                <?php foreach ($pilotak as $p): ?>
                <tr>
                    <td><strong><?= $p['az'] ?></strong></td>
                    <td><strong><?= htmlspecialchars($p['nev']) ?></strong></td>
                    <td><?= htmlspecialchars($p['nem']) ?></td>
                    <td><?= $p['szuldat'] ?></td>
                    <td><?= htmlspecialchars($p['nemzet']) ?></td>
                    
                    <?php if ($is_admin): ?>
                        <td>
                            <a href="index.php?oldal=pilota_szerkesztes&id=<?= $p['az'] ?>" class="btn btn-primary btn-sm">Szerkesztés</a>
                            <a href="index.php?oldal=pilota_torles&id=<?= $p['az'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törölni szeretnéd ezt a pilótát?')">Törlés</a>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?= $is_admin ? '6' : '5' ?>" class="text-center">Nincs a keresésnek megfelelő pilóta.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>