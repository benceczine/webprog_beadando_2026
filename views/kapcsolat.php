<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header text-white text-center py-3" style="background-color: var(--f1-dark); border-bottom: 3px solid var(--f1-red);">
                    <h3 class="mb-0">Kapcsolatfelvétel 🏎️</h3>
                </div>
                <div class="card-body p-4">
                    <p class="text-center mb-4">Kérdésed van a pilótákról? Találtál egy hibát az adatbázisban? Írj a csapatvezetésnek!</p>
                    
                    <form action="index.php?oldal=kapcsolat_mentes" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Neved</label>
                            <input type="text" name="nev" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">E-mail címed</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Üzenet szövege</label>
                            <textarea name="uzenet" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-f1 w-100 fs-5 fw-bold">Üzenet elküldése a Boxutcába</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>