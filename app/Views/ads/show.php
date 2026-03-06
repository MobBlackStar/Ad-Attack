<?php require '../app/Views/partials/header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            
            <!-- 🖼️ COLONNE GAUCHE : La Pub -->
            <div class="col-md-7 mb-4">
                <div class="card bg-secondary border-0 shadow-lg">
                    <!-- ARCHITECT FIX: Cleaned up the image tag to stop the text spill -->
                    <!-- basename() pour éviter les problèmes de chemin d'accès et de sécurité -->
                    <img src="<?= BASE_URL ?>/assets/uploads/<?= basename($ad->image_path) ?>" 
                         class="img-fluid rounded-top" 
                         alt="Ad Masterpiece">
                    
                    <div class="card-body p-4">
                        <!-- Sécurité XSS : Toujours échapper les données utilisateur ! -->
                        <h2 class="text-warning fw-bold italic">"<?= htmlspecialchars($ad->slogan) ?>"</h2>
                        <!-- FIX: Now shows the REAL name instead of just #1 -->
                        <p class="text-info">Exhibited by: <strong class="text-white"><?= htmlspecialchars($ad->agency_name ?? 'Agency #'.$ad->agency_id) ?></strong></p>
                        
                        <hr class="border-secondary">
                        <a href="<?= BASE_URL ?>/ad/index" class="btn btn-outline-light btn-sm mb-3">← Return to Exhibition</a>

                        <!-- TEAM: SARRA'S EDIT/DELETE BUTTONS (Requirement 3C) -->
                        <!-- SECURITY: Only the owner (or the Admin ID 1) can see these buttons -->
                        <?php if(\App\Core\Session::isLoggedIn() && ($ad->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1)): ?>
                            <div class="d-flex gap-2 border-top border-dark pt-3 mt-1">
                                <a href="<?= BASE_URL ?>/ad/edit/<?= $ad->id ?>" class="btn btn-sm btn-info w-50 fw-bold shadow-sm">
                                    ✏️ Edit Slogan
                                </a>
                                <!-- Bouton Supprimer avec confirmation JS -->
                                <a href="<?= BASE_URL ?>/ad/delete/<?= $ad->id ?>" class="btn btn-sm btn-danger w-50 fw-bold shadow-sm" onclick="return confirm('Team: Are you sure you want to SHRED this masterpiece? It cannot be undone!');">
                                    🗑️ Shred Ad
                                </a>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>

            <!-- 💬 COLONNE DROITE : Le Livre d'Or -->
            <div class="col-md-5">
                <div class="card bg-secondary border-0 shadow-lg p-4 h-100">
                    <h3 class="text-warning mb-4 fw-bold">Golden Book</h3>
                    
                    <div class="comment-scroll mb-4" style="max-height: 450px; overflow-y: auto;">
                        <?php if(empty($comments)): ?>
                            <p class="text-muted italic">The jury is silent. Be the first to speak!</p>
                        <?php else: ?>
                            <?php foreach($comments as $c): ?>
                                <div class="p-3 mb-3 bg-dark rounded border-start border-warning border-4 shadow-sm">
                                    <div class="d-flex align-items-center mb-2">
                                        <strong class="text-info"><?= htmlspecialchars($c->author) ?></strong>
                                      <!-- 🏆 GAMIFICATION : Affichage du grade (Cultivation Rank) -->    
                                        <span class="<?= $c->cultivation['color'] ?? 'badge bg-secondary' ?> ms-2" style="font-size: 0.65rem;">
                                            <?= $c->cultivation['rank'] ?? 'Novice' ?>
                                        </span>
                                    </div>
                                    <!-- Contenu du commentaire sécurisé -->
                                    <p class="mb-0 text-white-50" style="font-size: 0.9rem;"><?= htmlspecialchars($c->content) ?></p>
                                    <div class="text-end">
                                        <small class="text-muted" style="font-size: 0.7rem;"><?= date('d M, H:i', strtotime($c->created_at)) ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <hr class="border-secondary mt-auto">

                    <!-- Formulaire de commentaire : Uniquement pour les connectés -->
                    <?php if(\App\Core\Session::isLoggedIn()): ?>
                        <form action="<?= BASE_URL ?>/ad/comment" method="POST">
                     <!-- TOKEN CSRF (Bonus Sécurité) : Protection invisible contre les robots -->   
                            <input type="hidden" name="ad_id" value="<?= $ad->id ?>">
                            <div class="mb-3">
                                <label class="form-label text-warning small fw-bold">Your Marketing Expertise:</label>
                                <textarea name="content" class="form-control bg-dark text-white border-0" rows="3" placeholder="Write your feedback..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 fw-bold shadow">POST FEEDBACK</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-dark text-center py-3 border border-warning">
                            <p class="small mb-2">Want to judge this ad?</p>
                            <a href="<?= BASE_URL ?>/auth/login" class="btn btn-sm btn-warning">Login to Comment</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

<?php require '../app/Views/partials/footer.php'; ?>