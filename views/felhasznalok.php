<?php
// Most már a kep_engedely oszlopot is lekérjük!
$stmt = $dbh->query("SELECT id, felhasznalonev, kep_engedely FROM felhasznalok ORDER BY felhasznalonev ASC");
$userek = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Felhasználók kezelése</h2>

    <!-- Új felhasználó hozzáadása űrlap -->
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="card-title mb-0">Új felhasználó hozzáadása (Admin)</h5>
        </div>
        <div class="card-body">
            <form action="index.php?oldal=admin_felhasznalo_hozzaadas" method="POST" class="row g-3 align-items-center">
                <div class="col-auto">
                    <input type="text" name="user" class="form-control" placeholder="Felhasználónév" required>
                </div>
                <div class="col-auto">
                    <input type="password" name="pass" class="form-control" placeholder="Jelszó" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">Hozzáadás</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Felhasználók listája -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Felhasználónév</th>
                        <th class="text-center">Képfeltöltés Joga</th>
                        <th class="text-center">Egyéb Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($userek as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><strong><?= htmlspecialchars($u['felhasznalonev']) ?></strong></td>
                        
                        <!-- JOGOSULTSÁG GOMB -->
                        <td class="text-center">
                            <?php if($u['felhasznalonev'] !== 'admin'): ?>
                                <?php if($u['kep_engedely'] == 1): ?>
                                    <a href="index.php?oldal=kep_jog_valtas&id=<?= $u['id'] ?>" class="btn btn-secondary btn-sm">Jog visszavonása</a>
                                <?php else: ?>
                                    <a href="index.php?oldal=kep_jog_valtas&id=<?= $u['id'] ?>" class="btn btn-info btn-sm text-white">Jog megadása</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">Az Admin mindent tud</span>
                            <?php endif; ?>
                        </td>

                        <!-- MŰVELETEK GOMBOK -->
                        <td class="text-center">
                            <a href="index.php?oldal=felhasznalo_jelszo&id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Új jelszó</a>
                            <?php if($u['felhasznalonev'] !== 'admin'): ?>
                                <a href="index.php?oldal=felhasznalo_torles&id=<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd ezt a felhasználót?')">Törlés</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>