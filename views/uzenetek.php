<?php
// Lekérdezzük az adatokat az adatbázisból
$kereses = isset($_GET['kereses']) ? trim($_GET['kereses']) : '';

if ($kereses !== '') {
    // Ha van keresés
    $stmt = $dbh->prepare("SELECT * FROM uzenetek WHERE nev LIKE ? OR email LIKE ? OR uzenet LIKE ? ORDER BY id DESC");
    $keresesi_kifejezes = "%" . $kereses . "%";
    $stmt->execute([$keresesi_kifejezes, $keresesi_kifejezes, $keresesi_kifejezes]);
    $uzenetek_lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Ha nincs keresés (összes lekérése)
    $stmt = $dbh->query("SELECT * FROM uzenetek ORDER BY id DESC");
    $uzenetek_lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<h2>Beérkezett üzenetek (Admin)</h2>

<!-- Kereső űrlap -->
<form action="index.php" method="GET" style="margin-bottom: 20px;">
    <input type="hidden" name="oldal" value="uzenetek">
    <input type="text" name="kereses" placeholder="Keresés név, e-mail vagy szöveg alapján..." value="<?= htmlspecialchars($kereses) ?>">
    <button type="submit">Szűrés</button>
    
    <?php if ($kereses !== ''): ?>
        <a href="index.php?oldal=uzenetek">Vissza az összeshez</a>
    <?php endif; ?>
</form>

<!-- Egyszerű, formázatlan táblázat a frontendesnek -->
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Feladó neve</th>
            <th>E-mail cím</th>
            <th>Üzenet szövege</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($uzenetek_lista) > 0): ?>
            <?php foreach ($uzenetek_lista as $uz): ?>
            <tr>
                <td><strong><?= $uz['id'] ?></strong></td>
                <td><?= htmlspecialchars($uz['nev']) ?></td>
                <td><a href="mailto:<?= htmlspecialchars($uz['email']) ?>"><?= htmlspecialchars($uz['email']) ?></a></td>
                <td><?= nl2br(htmlspecialchars($uz['uzenet'])) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align: center;">Nincs a keresésnek megfelelő üzenet.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>