<?php
// views/crud.php
require_once('models/pilota_model.php');
$pilotak = get_osszes_pilota($dbh);
?>

<div class="container">
    <h2 class="text-center my-4">CRUD OPERATIONS</h2>
    <a href="index.php?oldal=pilota_hozzaadas" class="btn btn-primary mb-3">Add Pilóta</a>

    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>id</th>
                <th>Név</th>
                <th>Nem</th>
                <th>Születési dátum</th>
                <th>Nemzet</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pilotak as $p): ?>
            <tr>
                <td><strong><?= $p['az'] ?></strong></td>
                <td><strong><?= htmlspecialchars($p['nev']) ?></strong></td>
                <td><?= htmlspecialchars($p['nem']) ?></td>
                <td><?= $p['szuldat'] ?></td>
                <td><?= htmlspecialchars($p['nemzet']) ?></td>
                <td>
                    <a href="index.php?oldal=pilota_szerkesztes&id=<?= $p['az'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="index.php?oldal=pilota_torles&id=<?= $p['az'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>