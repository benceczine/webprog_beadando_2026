<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Kapcsolat</h4>
            </div>
            <div class="card-body">
                <p class="text-center">Kérjük, töltse ki az alábbi űrlapot üzenet küldéséhez.</p>
                <form action="index.php?oldal=kapcsolat_mentes" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Név:</label>
                        <input type="text" name="nev" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail cím:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Üzenet:</label>
                        <textarea name="uzenet" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Küldés</button>
                </form>
            </div>
        </div>
    </div>
</div>