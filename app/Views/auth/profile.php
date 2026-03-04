<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <div class="card bg-dark border-info shadow-lg position-relative overflow-hidden" style="border-radius: 20px;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: #00f0ff; box-shadow: 0 0 10px #00f0ff;"></div>

                <div class="card-body p-5 text-center">
                    
                    <h5 class="text-secondary font-monospace mb-4">AGENCY IDENTIFICATION</h5>
                    
                    <!-- HUGE ROBOT AVATAR -->
                    <div class="mb-5">
                        <div class="d-inline-block p-1 border border-warning rounded-circle bg-dark shadow-lg">
                            <img src="https://robohash.org/<?= $user->id ?>?set=set1&size=200x200" 
                                 class="rounded-circle" style="width: 150px; height: 150px; background: #0b0b0b;">
                        </div>
                        <h2 class="mt-3 text-white fw-bold"><?= htmlspecialchars($user->name) ?></h2>
                        <span class="<?= $cultivation['color'] ?> fs-5 px-4 py-2 mt-2 shadow"><?= $cultivation['rank'] ?></span>
                    </div>

                    <!-- STATS GRID -->
                    <div class="row mb-5 border-top border-bottom border-secondary py-3">
                        <div class="col-6 border-end border-secondary">
                            <h3 class="text-info fw-bold mb-0">ACTIVE</h3>
                            <small class="text-muted">Status</small>
                        </div>
                        <div class="col-6">
                            <h3 class="text-warning fw-bold mb-0">#<?= str_pad($user->id, 3, '0', STR_PAD_LEFT) ?></h3>
                            <small class="text-muted">Operative ID</small>
                        </div>
                    </div>

                    <!-- EDIT FORM -->
                    <details class="mb-4 text-start">
                        <summary class="btn btn-outline-light w-100 mb-3">⚙️ Edit Identity</summary>
                        <div class="card card-body bg-secondary border-0 mt-2">
                            <form action="<?= BASE_URL ?>/auth/updateProfile" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">
                                <label class="small text-info mb-1">New Agency Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="name" class="form-control bg-dark text-white border-0" value="<?= htmlspecialchars($user->name) ?>" required>
                                    <button class="btn btn-info fw-bold">SAVE</button>
                                </div>
                            </form>
                        </div>
                    </details>

                    <a href="<?= BASE_URL ?>/auth/deleteAccount" class="btn btn-outline-danger w-100 font-monospace" onclick="return confirm('WARNING: This will permanently erase your existence from the Arena. Proceed?');">
                        ⚠️ INITIATE SELF-DESTRUCT
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>