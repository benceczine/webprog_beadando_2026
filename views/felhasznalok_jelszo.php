<?php
// Lekérjük a konkrét felhasználót, hogy kiírhassuk a nevét
$id = isset($_GET['id']) ? $_GET['id'] : null;
$stmt = $dbh->prepare("SELECT felhasznalonev FROM felhasznalok WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="card-title mb-0">Új jelszó beállítása</h4>
                </div>
                <div class="card-body">
                    <p>Felhasználó: <strong class="fs-5"><?= htmlspecialchars($user['felhasznalonev']) ?></strong></p>
                    
                    <form action="index.php?oldal=admin_jelszo_mentes" method="POST">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="mb-3">
                            <label class="form-label">Új jelszó megadása</label>
                            <input type="password" name="uj_jelszo" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold">Jelszó módosítása</button>
                        <a href="index.php?oldal=felhasznalok" class="btn btn-secondary w-100 mt-2">Mégse</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>