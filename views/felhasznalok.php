<?php
$stmt = $dbh->query("SELECT id, felhasznalonev, kep_engedely FROM felhasznalok ORDER BY felhasznalonev ASC");
$userek = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4 text-warning fw-bold">Felhasználók és Jogosultságok (Admin)</h2>

    <div class="card shadow-sm mb-4 border-0" style="border-left: 5px solid #198754 !important;">
        <div class="card-body bg-light">
            <form action="index.php?oldal=admin_felhasznalo_hozzaadas" method="POST" class="row g-3 align-items-center">
                <div class="col-md-auto fw-bold text-success">
                    <i class="fas fa-user-plus"></i> Új pilóta felvétele:
                </div>
                <div class="col-md-4">
                    <input type="text" name="user" class="form-control border-success" placeholder="Felhasználónév" required>
                </div>
                <div class="col-md-4">
                    <input type="password" name="pass" class="form-control border-success" placeholder="Jelszó" required>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-success fw-bold w-100">Hozzáadás</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Felhasználónév</th>
                            <th class="text-center">Képfeltöltés Joga</th>
                            <th class="text-end pe-4">Fiók Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($userek as $u): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?= $u['id'] ?></td>
                            <td class="fw-bold fs-5"><?= htmlspecialchars($u['felhasznalonev']) ?></td>
                            
                            <td class="text-center">
                                <?php if($u['felhasznalonev'] !== 'admin'): ?>
                                    <?php if($u['kep_engedely'] == 1): ?>
                                        <a href="index.php?oldal=kep_jog_valtas&id=<?= $u['id'] ?>" class="btn btn-outline-danger btn-sm fw-bold">Jog visszavonása</a>
                                    <?php else: ?>
                                        <a href="index.php?oldal=kep_jog_valtas&id=<?= $u['id'] ?>" class="btn btn-info btn-sm text-white fw-bold">Jog megadása</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Rendszergazda (Mindent tud)</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-end pe-4">
                                <a href="index.php?oldal=felhasznalo_jelszo&id=<?= $u['id'] ?>" class="btn btn-secondary btn-sm">Új jelszó</a>
                                <?php if($u['felhasznalonev'] !== 'admin'): ?>
                                    <a href="index.php?oldal=felhasznalo_torles&id=<?= $u['id'] ?>" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Biztosan törlöd ezt a felhasználót?')">Törlés</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>