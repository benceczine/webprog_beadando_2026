<?php
// Lekérjük a felhasználó nevét az ID alapján, hogy szépen ki tudjuk írni, kinek cseréljük a jelszavát
$user_id = $_GET['id'] ?? 0;
$stmt = $dbh->prepare("SELECT felhasznalonev FROM felhasznalok WHERE id = ?");
$stmt->execute([$user_id]);
$cel_user = $stmt->fetch();

if (!$cel_user) {
    echo "<div class='alert alert-danger mt-4'>Hiba: A felhasználó nem található!</div>";
    exit;
}
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header text-white text-center py-3" style="background-color: var(--f1-dark); border-bottom: 4px solid var(--f1-red);">
                    <h3 class="mb-0 fw-bold"><i class="fas fa-key"></i> Új jelszó beállítása</h3>
                </div>
                <div class="card-body p-4 bg-light">
                    <p class="text-center mb-4 fs-5 text-muted">
                        Fiók: <strong class="text-danger fs-4"><?= htmlspecialchars($cel_user['felhasznalonev']) ?></strong>
                    </p>

                    <form action="index.php?oldal=admin_jelszo_mentes" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user_id) ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ide írd be az új jelszót:</label>
                            <input type="text" name="uj_jelszo" class="form-control form-control-lg shadow-sm border-dark" required>
                            <small class="text-muted">A rendszer ezt azonnal titkosítva fogja elmenteni.</small>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php?oldal=felhasznalok" class="btn btn-secondary btn-lg fw-bold px-4">Mégsem</a>
                            <button type="submit" class="btn btn-warning btn-lg fw-bold px-4 shadow">Jelszó Mentése</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>