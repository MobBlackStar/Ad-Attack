<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <!-- On utilise la boussole pour trouver le CSS, peu importe l'ordinateur -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <!-- Message de succès quand on poste un commentaire -->
    <?php if($msg = \App\Core\Session::flash('success')): ?>
        <div class="alert alert-success text-center border-0 rounded-0">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="row">
            
            <!-- 🖼️ COLONNE GAUCHE : La Pub -->
            <div class="col-md-7 mb-4">
                <div class="card bg-secondary border-0 shadow-lg">
                    <!-- Image avec le chemin corrigé pour localhost -->
                    <!-- On utilise la boussole pour aller directement dans le dossier uploads -->
<img src="<?= BASE_URL ?>/assets/uploads/<?= basename($ad->image_path) ?>" 
     class="card-img-top" 
     style="height: 250px; object-fit: cover;">
                         class="img-fluid rounded-top" 
                         alt="Ad Masterpiece">
                    
                    <div class="card-body p-4">
                        <h2 class="text-warning fw-bold italic">"<?= $ad->slogan ?>"</h2>
                        <p class="text-info">Exhibited by Agency #<?= $ad->agency_id ?></p>
                        <hr class="border-secondary">
                        <a href="index.php?url=ad/index" class="btn btn-outline-light btn-sm">← Return to Exhibition</a>
                    </div>
                </div>
            </div>

            <!-- 💬 COLONNE DROITE : Le Livre d'Or /PARTIE DES COMMENTAIRES -->
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
                                        <strong class="text-info"><?= $c->author ?></strong>
                                        <!-- Le badge de rang dynamique de Fedi -->
                                        <span class="<?= $c->cultivation['color'] ?? 'badge bg-secondary' ?> ms-2" style="font-size: 0.65rem;">
                                            <?= $c->cultivation['rank'] ?? 'Novice' ?>
                                        </span>
                                    </div>
                                    <p class="mb-0 text-white-50" style="font-size: 0.9rem;"><?= $c->content ?></p>
                                    <div class="text-end">
                                        <small class="text-muted" style="font-size: 0.7rem;"><?= date('d M, H:i', strtotime($c->created_at)) ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <hr class="border-secondary mt-auto">

                    <!-- Formulaire de commentaire -->
                    <form action="index.php?url=ad/comment" method="POST">
                        <input type="hidden" name="ad_id" value="<?= $ad->id ?>">
                        <div class="mb-3">
                            <label class="form-label text-warning small fw-bold">Your Marketing Expertise:</label>
                            <textarea name="content" class="form-control bg-dark text-white border-0" rows="3" placeholder="Write your feedback..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold shadow">POST FEEDBACK</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer bas de page -->
    <footer class="text-center mt-5 pb-4 text-muted small">
        &copy; 2026 Ad-Attack Factory. Built by the Squad.
    </footer>

</body>
</html>