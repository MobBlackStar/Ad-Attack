<?php require '../app/Views/partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="text-warning text-center mb-5 font-monospace display-4">LIVE CAMPAIGNS</h1>

        <?php if(empty($ads)): ?>
            <div class="text-center py-5 bg-dark border border-secondary rounded shadow">
                <h3 class="text-muted font-monospace">SIGNAL LOST... NO ADS FOUND.</h3>
                <a href="<?= BASE_URL ?>/ad/submit" class="btn btn-warning mt-3 fw-bold">INITIATE FIRST ATTACK</a>
            </div>
        <?php else: ?>
            <?php foreach($ads as $ad): ?>
                <!-- TEAM: The "Billboard" Card Style -->
                <div class="card bg-secondary border-0 shadow-lg mb-5 position-relative" style="border-radius: 20px; overflow: hidden;">
                    
                    <!-- Header -->
                    <div class="card-header bg-dark border-0 p-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="https://robohash.org/<?= $ad->agency_id ?>?set=<?= htmlspecialchars($ad->avatar_set ?? 'set1') ?>" 
                                 class="rounded-circle border border-secondary me-3"
                                 style="width: 45px; height: 45px; background: #000;">
                            <div>
                                <h6 class="mb-0 text-white"><?= htmlspecialchars($ad->agency_name ?? 'Unknown Agency') ?></h6>
                                <small class="text-info font-monospace">ID: #<?= str_pad($ad->agency_id, 3, '0', STR_PAD_LEFT) ?></small>
                            </div>
                        </div>
                        
                        <!-- THE INCINERATOR: MODAL TRIGGER -->
                        <?php if($ad->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1): ?>
                            <!-- Clicking this opens the specific modal for this Ad -->
                            <button type="button" class="btn btn-sm btn-outline-danger border-0" 
                                    data-bs-toggle="modal" data-bs-target="#deleteAdModal-<?= $ad->id ?>">
                                🗑️
                            </button>
                            
                            <!-- THE CYBERPUNK DELETE MODAL -->
                            <div class="modal fade" id="deleteAdModal-<?= $ad->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-white border-danger shadow-lg" style="box-shadow: 0 0 20px rgba(255, 0, 60, 0.5);">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-danger fw-bold font-monospace">⚠️ ERADICATION PROTOCOL</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center p-4">
                                            <p class="fs-5">Are you sure you want to delete this campaign?</p>
                                            <p class="small text-muted font-monospace">"<?= htmlspecialchars($ad->slogan) ?>"</p>
                                            <div class="alert alert-danger bg-transparent border-danger mt-3 small">
                                                This action is irreversible. The data will be lost in the void.
                                            </div>
                                        </div>
                                        <div class="modal-footer border-secondary justify-content-center">
                                            <button type="button" class="btn btn-outline-light font-monospace" data-bs-dismiss="modal">ABORT</button>
                                            <a href="<?= BASE_URL ?>/ad/delete/<?= $ad->id ?>" class="btn btn-danger fw-bold font-monospace shadow">CONFIRM DELETION</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php $isExternal = !empty($ad->image_path) && preg_match('#^https?://#i', $ad->image_path); ?>
                    <img src="<?= $isExternal ? htmlspecialchars($ad->image_path) : (BASE_URL . '/assets/uploads/' . basename($ad->image_path)) ?>" class="img-fluid w-100" style="max-height: 600px; object-fit: contain; background: #000;">

                    <div class="card-body p-4 bg-dark">
                        <h2 class="text-warning text-center mb-4 fst-italic">"<?= htmlspecialchars($ad->slogan) ?>"</h2>
                        
                        <div class="d-flex justify-content-between align-items-center border-top border-secondary pt-3">
                            <!-- UPDATED VOTING UI -->
                            <div id="vote-area-<?= $ad->id ?>">
                                <span id="score-<?= $ad->id ?>" class="fs-4 fw-bold text-info me-3 font-monospace">
                                    <?= ($ad->has_voted || \App\Core\Auth::id() == 1) ? $ad->vote_count : '???' ?>
                                </span>
                                
                                <?php if(\App\Core\Session::isLoggedIn()): ?>
                                    <!-- Dynamic Button Class based on status -->
                                    <button class="btn <?= $ad->has_voted ? 'btn-success' : 'btn-warning' ?> vote-btn px-4 rounded-pill fw-bold" 
                                            data-id="<?= $ad->id ?>">
                                        <?= $ad->has_voted ? '✅ VOTED' : '🔥 ATTACK' ?>
                                    </button>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/auth/login" class="btn btn-sm btn-outline-info">Login to Vote</a>
                                <?php endif; ?>
                            </div>

                            <a href="<?= BASE_URL ?>/ad/show/<?= $ad->id ?>" class="text-decoration-none text-muted small font-monospace">
                                💬 VIEW INTEL
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>