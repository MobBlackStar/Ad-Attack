<?php require '../app/Views/partials/header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            
            <!-- 🖼️ LEFT COLUMN: The Ad -->
            <div class="col-md-7 mb-4">
                <div class="card bg-secondary border-0 shadow-lg">
                    
                    <!-- FEDI: Smart Display. Show Image OR External Link Button -->
                    <?php if(!empty($ad->image_path)): ?>
                        <?php $isExternal = preg_match('#^https?://#i', $ad->image_path); ?>
                        <?php if($isExternal): ?>
                            <img src="<?= htmlspecialchars($ad->image_path) ?>" 
                                 class="img-fluid rounded-top w-100" style="max-height: 500px; object-fit: contain; background: #000;" alt="Ad Masterpiece">
                        <?php else: ?>
                            <img src="<?= BASE_URL ?>/assets/uploads/<?= basename($ad->image_path) ?>" 
                                 class="img-fluid rounded-top w-100" style="max-height: 500px; object-fit: contain; background: #000;" alt="Ad Masterpiece">
                        <?php endif; ?>
                    <?php elseif(!empty($ad->external_link)): ?>
                        <div class="p-5 text-center bg-dark rounded-top d-flex flex-column justify-content-center" style="height: 300px;">
                            <h1 class="display-1">🔗</h1>
                            <a href="<?= htmlspecialchars($ad->external_link) ?>" target="_blank" class="btn btn-outline-info mt-3 fw-bold font-monospace mx-auto">ACCESS EXTERNAL MASTERPIECE</a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body p-4 bg-dark">
                        <h2 class="text-warning fw-bold fst-italic">"<?= htmlspecialchars($ad->slogan) ?>"</h2>
                        <p class="text-info font-monospace small">Exhibited by: <strong class="text-white"><?= htmlspecialchars($ad->agency_name ?? 'Unknown') ?></strong></p>
                        
                        <hr class="border-secondary">
                        <a href="<?= BASE_URL ?>/ad" class="btn btn-outline-light btn-sm mb-3 font-monospace">← Return to Exhibition</a>

                        <!-- TEAM: SARRA'S EDIT/DELETE BUTTONS -->
                        <?php if(\App\Core\Session::isLoggedIn() && ($ad->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1)): ?>
                            <div class="d-flex gap-2 border-top border-secondary pt-3 mt-1">
                                <a href="<?= BASE_URL ?>/ad/edit/<?= $ad->id ?>" class="btn btn-sm btn-info w-50 fw-bold shadow-sm font-monospace">
                                    ✏️ EDIT SLOGAN
                                </a>
                                
                                <!-- FEDI'S FIX: The Cyberpunk Eradicate Modal Trigger -->
                                <button type="button" class="btn btn-sm btn-danger w-50 fw-bold shadow-sm font-monospace" data-bs-toggle="modal" data-bs-target="#shredAdModal">
                                    🗑️ SHRED AD
                                </button>
                            </div>

                            <!-- THE CYBERPUNK DELETE MODAL -->
                            <div class="modal fade" id="shredAdModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-white border-danger shadow-lg" style="box-shadow: 0 0 20px rgba(255, 0, 60, 0.5);">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-danger fw-bold font-monospace">⚠️ ERADICATION PROTOCOL</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center p-4">
                                            <p class="fs-5">Are you sure you want to permanently shred this campaign?</p>
                                            <div class="alert alert-danger bg-transparent border-danger mt-3 small font-monospace">This action is irreversible. The data will be lost in the void.</div>
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
                </div>
            </div>

            <!-- 💬 RIGHT COLUMN : The Golden Book -->
            <div class="col-md-5">
                <div class="card bg-secondary border-0 shadow-lg p-4 h-100">
                    <h3 class="text-warning mb-4 fw-bold font-monospace">GOLDEN BOOK</h3>
                    
                    <div class="comment-scroll mb-4" style="max-height: 450px; overflow-y: auto;">
                        <?php if(empty($comments)): ?>
                            <p class="text-muted fst-italic">The jury is silent. Be the first to speak!</p>
                        <?php else: ?>
                            <?php foreach($comments as $c): ?>
                                <div class="p-3 mb-3 bg-dark rounded border-start border-warning border-4 shadow-sm">
                                    <div class="d-flex align-items-center mb-2">
                                        <strong class="text-info"><?= htmlspecialchars($c->author) ?></strong>
                                        <span class="<?= $c->cultivation['color'] ?? 'badge bg-secondary' ?> ms-2" style="font-size: 0.65rem;">
                                            <?= $c->cultivation['rank'] ?? 'Novice' ?>
                                        </span>
                                    </div>
                                    <p class="mb-0 text-white-50" style="font-size: 0.9rem;"><?= htmlspecialchars($c->content) ?></p>
                                    <div class="text-end mt-2">
                                        <small class="text-muted font-monospace" style="font-size: 0.7rem;"><?= date('d M, H:i', strtotime($c->created_at)) ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <hr class="border-secondary mt-auto">

                    <!-- Formulaire de commentaire -->
                    <?php if(\App\Core\Session::isLoggedIn()): ?>
                        <form action="<?= BASE_URL ?>/ad/comment" method="POST">
                            <input type="hidden" name="ad_id" value="<?= $ad->id ?>">
                            <div class="mb-3">
                                <label class="form-label text-warning small fw-bold font-monospace">Your Marketing Expertise:</label>
                                <textarea name="content" class="form-control bg-dark text-white border-info" rows="3" placeholder="Write your feedback..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 fw-bold shadow font-monospace">POST FEEDBACK</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-dark text-center py-3 border border-warning">
                            <p class="small mb-2 font-monospace">Want to judge this ad?</p>
                            <a href="<?= BASE_URL ?>/auth/login" class="btn btn-sm btn-warning fw-bold">Login to Comment</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php require '../app/Views/partials/footer.php'; ?>