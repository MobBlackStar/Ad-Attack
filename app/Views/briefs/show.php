<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <!-- 1. THE BRIEF (The Mission Target) -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="card bg-dark border-warning shadow-lg" style="border-radius: 20px; border-width: 2px;">
                <div class="row g-0">
                    <div class="col-md-5 position-relative">
                        <?php $briefImg = !empty($brief->image) ? basename($brief->image) : ''; ?>
                        <img src="<?= $briefImg ? BASE_URL . '/assets/uploads/' . htmlspecialchars($briefImg) : '' ?>" 
                             class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="<?= htmlspecialchars($brief->title ?? 'Target') ?>"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\'%3E%3Crect fill=\'%23333\' width=\'400\' height=\'300\'/%3E%3Ctext fill=\'%23666\' x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'18\'%3EImage unavailable%3C/text%3E%3C/svg%3E';">
                    </div>
                    <div class="col-md-7 p-4">
                        <span class="badge bg-warning text-dark mb-2"><?= $brief->category ?></span>
                        <h1 class="text-white fw-bold"><?= htmlspecialchars($brief->title) ?></h1>
                        <p class="text-info small">Mission Deadline: <?= $brief->deadline ?></p>
                        
                        <hr class="border-secondary">
                        
                        <h4 class="text-warning">The Mission:</h4>
                        <p class="lead text-light"><?= nl2br(htmlspecialchars($brief->description)) ?></p>

                        <div class="mt-4">
                            <!-- This button will link to Sarra's AdController later -->
                           <?php if(\App\Core\Session::isLoggedIn()): ?>
                                <a href="<?= BASE_URL ?>/ad/submit/<?= $brief->id ?>" class="btn btn-lg btn-warning fw-bold px-4 shadow">
                                    🚀 LAUNCH ATTACK
                                </a>
                            <?php else: ?>
                                <div class="alert alert-secondary text-center border-0 shadow">
                                    <h5 class="text-warning">Want to participate?</h5>
                                    <p class="small text-light">Only registered agencies can submit designs to this brief.</p>
                                    <a href="<?= BASE_URL ?>/auth/login" class="btn btn-warning w-100 fw-bold">JOIN THE ARENA</a>
                                </div>
                            <?php endif; ?>
                            <a href="<?= BASE_URL ?>/brief" class="btn btn-outline-light ms-2">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. THE ADS (The Submission Feed) -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h3 class="text-info mb-0">🛡️ LIVE ATTACKS (<?= count($ads) ?>)</h3>
            
            <!-- THE AD SORTER -->
            <div class="btn-group shadow-sm">
                <a href="<?= BASE_URL ?>/brief/show/<?= $brief->id ?>?sort=newest" class="btn btn-sm <?= ($currentSort == 'newest') ? 'btn-info' : 'btn-outline-info' ?>">Newest</a>
                <a href="<?= BASE_URL ?>/brief/show/<?= $brief->id ?>?sort=trending" class="btn btn-sm <?= ($currentSort == 'trending') ? 'btn-info' : 'btn-outline-info' ?>">🔥 Top Rated</a>
            </div>
        </div>

        <?php if(empty($ads)): ?>
            <div class="text-center py-5 bg-secondary rounded border border-secondary">
                <p class="text-muted mb-0">The target is untouched. Will you be the first to strike?</p>
            </div>
        <?php else: ?>
            <?php foreach($ads as $ad): ?>
                <div class="card bg-secondary border-0 mb-5">
                    
                    <div class="card-header bg-dark border-bottom border-secondary d-flex justify-content-between align-items-center">
                        <span class="text-info small">AGENCY: <strong class="text-white"><?= htmlspecialchars($ad->agency_name) ?></strong></span>
                        
                        <!-- THE INCINERATOR FIX (No Modals, 100% reliable) - Modal confirm instead of browser pop-up -->
                        <?php if($ad->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1): ?>
                            <button type="button" class="btn btn-sm btn-danger px-2 py-0" data-bs-toggle="modal" data-bs-target="#deleteAdModal-<?= $ad->id ?>">
                                ERADICATE
                            </button>
                            <!-- ERADICATION CONFIRM MODAL -->
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
                                            <div class="alert alert-danger bg-transparent border-danger mt-3 small">This action is irreversible.</div>
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

                    <img src="<?= BASE_URL ?>/assets/uploads/<?= basename($ad->image_path) ?>" class="img-fluid w-100" style="max-height: 450px; object-fit: contain; background: #050505;">
                    
                    <div class="card-body bg-dark text-center">
                        <h4 class="text-warning mb-3">"<?= htmlspecialchars($ad->slogan) ?>"</h4>
                        
                        <div class="d-flex justify-content-between align-items-center border-top border-secondary pt-3">
                            <div id="vote-area-<?= $ad->id ?>">
                                <span id="score-<?= $ad->id ?>" class="fs-5 fw-bold text-info me-2">
                                    <?= ($ad->has_voted || \App\Core\Auth::id() == 1) ? $ad->vote_count : '???' ?>
                                </span>
                                <?php if(\App\Core\Session::isLoggedIn()): ?>
                                    <button class="btn btn-sm <?= $ad->has_voted ? 'btn-success' : 'btn-warning' ?> vote-btn fw-bold px-3" data-id="<?= $ad->id ?>">
                                        <?= $ad->has_voted ? '✅ VOTED' : '🔥 ATTACK' ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <a href="<?= BASE_URL ?>/ad/show/<?= $ad->id ?>" class="btn btn-sm btn-outline-info">TERMINAL 💬</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>