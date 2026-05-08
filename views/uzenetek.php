<?php
// 1. Adatok lekérése közvetlenül a nézetben (hogy ne legyen Undefined variable hiba)
$kereses = isset($_GET['kereses']) ? trim($_GET['kereses']) : '';

if ($kereses !== '') {
    // Keresünk a névben, e-mailben vagy az üzenet szövegében is
    $stmt = $dbh->prepare("SELECT * FROM uzenetek WHERE nev LIKE ? OR email LIKE ? OR uzenet LIKE ? ORDER BY id DESC");
    $search_term = "%$kereses%";
    $stmt->execute([$search_term, $search_term, $search_term]);
} else {
    // Ha nincs keresés, csak kilistázzuk az összeset
    $stmt = $dbh->query("SELECT * FROM uzenetek ORDER BY id DESC");
}
$uzenetek_lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="card p-4 shadow-sm border-0">
    <h3 class="fw-bold mb-4">Beérkezett üzenetek (Admin)</h3>

    <form method="GET" class="row g-2 mb-4">
        <input type="hidden" name="oldal" value="uzenetek">
        <div class="col-auto">
            <input type="text" name="kereses" class="form-control" placeholder="Keresés az üzenetekben..." value="<?= htmlspecialchars($kereses) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Szűrés</button>
            <?php if ($kereses !== ''): ?>
                <a href="index.php?oldal=uzenetek" class="btn btn-outline-secondary">Vissza</a>
            <?php endif; ?>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Név</th>
                    <th>E-mail</th>
                    <th>Üzenet</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($uzenetek_lista) > 0): ?>
                    <?php foreach ($uzenetek_lista as $uz): ?>
                    <tr>
                        <td class="fw-bold"><?= htmlspecialchars($uz['nev']) ?></td>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($uz['email']) ?>" class="text-decoration-none">
                                <?= htmlspecialchars($uz['email']) ?>
                            </a>
                        </td>
                        <td><?= nl2br(htmlspecialchars($uz['uzenet'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Nincs beérkezett üzenet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>