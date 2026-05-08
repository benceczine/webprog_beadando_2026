<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0">
                <div class="card-header text-center py-3" style="background-color: var(--f1-dark); color: white; border-bottom: 4px solid var(--f1-red);">
                    <h3 class="mb-0 fw-bold">Csatlakozás a Csapathoz</h3>
                </div>
                <div class="card-body p-4 bg-light">
                    <p class="text-center text-muted mb-4">Regisztrálj, hogy hozzáférj a Forma-1 adatbázis funkcióihoz!</p>
                    
                    <form action="index.php?oldal=regisztracio_mentes" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Felhasználónév</label>
                            <input type="text" name="user" class="form-control shadow-sm" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jelszó</label>
                            <input type="password" name="pass" class="form-control shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Jelszó megerősítése</label>
                            <input type="password" name="pass2" class="form-control shadow-sm" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 fw-bold fs-5 shadow">Regisztráció</button>
                    </form>
                </div>
                <div class="card-footer text-center py-3 bg-white">
                    <small class="text-muted">Már van fiókod? <a href="index.php?oldal=login" style="color: var(--f1-red); font-weight: bold;">Lépj be itt!</a></small>
                </div>
            </div>
        </div>
    </div>
</div>