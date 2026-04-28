<div class="container mt-4">
    <h2>Bejelentkezés</h2>
    <form action="index.php?oldal=login_ellenorzes" method="POST">
        <div class="mb-3">
            <label>Felhasználónév:</label>
            <input type="text" name="user" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jelszó:</label>
            <input type="password" name="pass" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Belépés</button>
    </form>
</div>