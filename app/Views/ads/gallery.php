<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-warning text-center mb-5 fw-bold" style="letter-spacing: 2px;">🖼️ THE AD EXHIBITION</h1>
    
    <div class="row justify-content-center">
        <?php if(empty($ads)): ?>
            <div class="col-12 text-center">
                <p class="text-muted italic">L'arène est vide... Soyez le premier à attaquer !</p>
            </div>
        <?php else: ?>
            
            <?php foreach($ads as $ad): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary border-0 shadow-lg h-100">
                        <div style="height: 250px; overflow: hidden;">
                            <img src="<?= BASE_URL ?>/assets/uploads/<?= basename($ad->image_path) ?>" 
                                 class="card-img-top" 
                                 style="height: 250px; width: 100%; object-fit: cover;" 
                                 alt="Ad Image">
                        </div>
                        
                        <div class="card-body d-flex flex-column text-center">
                            <h4 class="card-title text-warning mt-2">"<?= htmlspecialchars($ad->slogan) ?>"</h4>
                            
                            <!-- THE VOTING BOX -->
                            <div class="my-3 p-2 bg-dark rounded border border-secondary d-flex justify-content-between align-items-center">
                                <span id="score-<?= $ad->id ?>" class="text-warning fw-bold">
                                    <!-- TEAM: Using the FULL address (\App\Core\Auth) so the View doesn't crash! -->
                                    <?php if($ad->has_voted || \App\Core\Auth::id() == 1): ?>
                                        Score: <?= $ad->vote_count ?>
                                    <?php else: ?>
                                        Score: ???
                                    <?php endif; ?>
                                </span>

                                <?php if(\App\Core\Session::isLoggedIn()): ?>
                                    <?php if(!$ad->has_voted): ?>
                                        <button class="btn btn-sm btn-warning vote-btn" data-id="<?= $ad->id ?>">🔥 Vote</button>
                                    <?php else: ?>
                                        <span class="badge bg-success">✅ Voted</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/auth/login" class="btn btn-sm btn-outline-info">Login</a>
                                <?php endif; ?>
                            </div>

                            <div class="mt-auto">
                                <a href="<?= BASE_URL ?>/ad/show/<?= $ad->id ?>" class="btn btn-outline-warning w-100 fw-bold">
                                    VIEW & COMMENT
                                </a>
                            </div>
                        </div>
                    </div>
                </div> <?php if($ad->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1): ?>
    <a href="<?= BASE_URL ?>/ad/delete/<?= $ad->id ?>" class="btn btn-sm btn-outline-danger mt-2" onclick="return confirm('Team: Burn this masterpiece?');">Shred Ad</a>
<?php endif; ?>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

    <div class="text-center mt-5 mb-5">
        <a href="<?= BASE_URL ?>/home" class="text-muted d-inline-block text-decoration-none">← Back to Lobby</a>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>