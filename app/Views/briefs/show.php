<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <!-- 1. THE BRIEF (The Mission Target) -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="card bg-dark border-warning shadow-lg" style="border-radius: 20px; border-width: 2px;">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="<?= BASE_URL ?>/assets/uploads/<?= $brief->image ?>" 
                             class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="Target Object">
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
                        
                        <!-- THE INCINERATOR FIX (No Modals, 100% reliable) -->
                        <?php if($ad->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1): ?>
                            <a href="<?= BASE_URL ?>/ad/delete/<?= $ad->id ?>" class="btn btn-sm btn-danger px-2 py-0" onclick="return confirm('SYSTEM WARNING: Erase this campaign permanently?');">
                                ERADICATE
                            </a>
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
                                <?php if(\App\Core\Session::isLoggedIn() && !$ad->has_voted): ?>
                                    <button class="btn btn-sm btn-warning vote-btn fw-bold px-3" data-id="<?= $ad->id ?>">ATTACK</button>
                                <?php elseif(\App\Core\Session::isLoggedIn()): ?>
                                    <span class="badge bg-success text-dark">LOCKED</span>
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