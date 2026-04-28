<div class="container mt-4">
    <h2>Kapcsolat</h2>
    <form action="index.php?oldal=kapcsolat_mentes" method="POST">
        <div class="mb-3">
            <label>Név:</label>
            <input type="text" name="nev" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Üzenet:</label>
            <textarea name="uzenet" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Küldés</button>
    </form>
</div>