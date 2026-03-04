<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            
            <!-- THE ID CARD -->
            <div class="card bg-dark border-info shadow-lg position-relative overflow-hidden" style="border-radius: 20px;">
                
                <!-- Background Glitch Effect -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: #00f0ff; box-shadow: 0 0 15px #00f0ff;"></div>

                <div class="card-body p-5 text-center">
                    
                    <h5 class="text-info font-monospace mb-4 fw-bold" style="letter-spacing: 2px;">[ AGENCY_IDENTIFICATION ]</h5>
                    
                    <!-- HUGE ROBOT AVATAR -->
                    <div class="mb-5">
                        <div class="d-inline-block p-1 border border-warning rounded-circle bg-dark shadow-lg">
                            <img src="https://robohash.org/<?= $user->id ?>?set=set1&size=200x200" 
                                 class="rounded-circle" style="width: 150px; height: 150px; background: #0b0b0b; box-shadow: inset 0 0 10px #f3e600;">
                        </div>
                        <h2 class="mt-4 text-white fw-bold font-monospace text-uppercase"><?= htmlspecialchars($user->name) ?></h2>
                        
                        <!-- CULTIVATION RANK -->
                        <div class="mt-3">
                            <span class="<?= $cultivation['color'] ?? 'badge bg-secondary' ?> fs-6 px-4 py-2 shadow border border-dark">
                                <?= $cultivation['rank'] ?? 'Unknown Entity' ?>
                            </span>
                        </div>
                    </div>

                    <!-- STATS GRID -->
                    <div class="row mb-5 border-top border-bottom border-secondary py-3 bg-secondary rounded" style="opacity: 0.9;">
                        <div class="col-6 border-end border-dark">
                            <h3 class="text-info fw-bold mb-0 font-monospace">ACTIVE</h3>
                            <small class="text-light opacity-75 font-monospace">Status</small>
                        </div>
                        <div class="col-6">
                            <h3 class="text-warning fw-bold mb-0 font-monospace">#<?= str_pad($user->id, 3, '0', STR_PAD_LEFT) ?></h3>
                            <small class="text-light opacity-75 font-monospace">Operative ID</small>
                        </div>
                    </div>

                    <!-- EDIT FORM -->
                    <details class="mb-4 text-start">
                        <summary class="btn btn-outline-info w-100 mb-3 fw-bold font-monospace" style="letter-spacing: 1px;">⚙️ CONFIGURE IDENTITY</summary>
                        <div class="card card-body bg-dark border-info mt-2">
                            <form action="<?= BASE_URL ?>/auth/updateProfile" method="POST">
                                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">
                                <label class="small text-info mb-2 font-monospace">NEW AGENCY DESIGNATION</label>
                                <div class="input-group mb-2 shadow-sm">
                                    <input type="text" name="name" class="form-control bg-secondary text-white border-0 fw-bold" value="<?= htmlspecialchars($user->name) ?>" required>
                                    <button class="btn btn-info fw-bold text-dark font-monospace">UPDATE</button>
                                </div>
                            </form>
                        </div>
                    </details>

                    <!-- DANGER ZONE: Triggers the Modal below -->
                    <button type="button" class="btn btn-outline-danger w-100 font-monospace fw-bold mt-3" data-bs-toggle="modal" data-bs-target="#selfDestructModal">
                        ⚠️ INITIATE SELF-DESTRUCT
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- THE CYBERPUNK SELF-DESTRUCT MODAL -->
<!-- ========================================================================= -->
<div class="modal fade" id="selfDestructModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-danger" style="box-shadow: 0 0 40px rgba(255,0,60,0.4); border-width: 2px;">
            
            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title text-danger fw-bold font-monospace w-100 text-center">CRITICAL SYSTEM WARNING</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body text-center pt-2 pb-4">
                <div class="mb-3">
                    <span style="font-size: 4rem;">☢️</span>
                </div>
                <p class="text-white fs-5 font-monospace">
                    You are about to permanently eradicate <br>
                    <strong class="text-warning">Agency #<?= str_pad($user->id, 3, '0', STR_PAD_LEFT) ?></strong> from the grid.
                </p>
                <div class="alert alert-danger bg-transparent border-danger text-start small font-monospace mt-3">
                    > Purging Agency Data...<br>
                    > Incinerating Mission Briefs...<br>
                    > Deleting Campaign Ads...<br>
                    > Erasing Cultivation Rank...<br>
                    <span class="fw-bold mt-2 d-block">THIS PROCESS IS IRREVERSIBLE.</span>
                </div>
            </div>
            
            <div class="modal-footer border-0 justify-content-center pt-0 pb-4">
                <button type="button" class="btn btn-outline-light font-monospace px-4" data-bs-dismiss="modal">ABORT</button>
                <a href="<?= BASE_URL ?>/auth/deleteAccount" class="btn btn-danger fw-bold font-monospace px-4 shadow">CONFIRM ERADICATION</a>
            </div>
            
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>