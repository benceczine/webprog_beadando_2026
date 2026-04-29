<?php
// Lekérjük a felhasználókat az adatbázisból
$stmt = $dbh->query("SELECT id, felhasznalonev FROM felhasznalok ORDER BY felhasznalonev ASC");
$userek = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Felhasználók kezelése</h2>

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

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Felhasználónév</th>
                        <th class="text-center">Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($userek as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><strong><?= htmlspecialchars($u['felhasznalonev']) ?></strong></td>
                        <td class="text-center">
                            <a href="index.php?oldal=felhasznalo_jelszo&id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Új jelszó</a>
                            
                            <?php if($u['felhasznalonev'] !== 'admin'): ?>
                                <a href="index.php?oldal=felhasznalo_torles&id=<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd ezt a felhasználót?')">Törlés</a>
                            <?php else: ?>
                                <span class="badge bg-secondary ms-1">Védett admin fiók</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>