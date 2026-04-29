<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title mb-0">Regisztráció</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?oldal=regisztracio_mentes" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Felhasználónév</label>
                            <input type="text" name="user" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jelszó</label>
                            <input type="password" name="pass" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jelszó újra</label>
                            <input type="password" name="pass2" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-info w-100 text-white">Regisztrálok!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>