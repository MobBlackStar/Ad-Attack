<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <!-- TEAM : J'ai enlevé le "/" au début. Maintenant Bootstrap va se charger ! -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <!-- On affiche le message de succès s'il y en a un -->
    <?php if($msg = \App\Core\Session::flash('success')): ?>
        <div class="alert alert-success text-center mb-0">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="row">
            
            <!-- 🖼️ La Pub en grand -->
            <div class="col-md-7">
                <div class="card bg-secondary border-0 shadow-lg">
                    <!-- TEAM : Pas de "/" ici non plus ! -->
                    <img src="<?= $ad->image_path ?>" class="img-fluid rounded-top" alt="Ad">
                    <div class="card-body">
                        <h2 class="text-warning italic">"<?= $ad->slogan ?>"</h2>
                        <p class="text-info small">Par l'Agence n°<?= $ad->agency_id ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="index.php?url=ad/index" class="btn btn-outline-light">← Galerie</a>
                    <a href="index.php?url=home" class="btn btn-outline-warning ms-2">Accueil</a>
                </div>
            </div>

            <!-- 💬 L'Espace Commentaires -->
            <div class="col-md-5">
                <div class="card bg-secondary p-4 shadow-lg h-100">
                    <h3 class="text-warning mb-4">Livre d'Or</h3>
                    
                    <div class="comment-box mb-4" style="max-height: 400px; overflow-y: auto;">
                        <?php if(empty($comments)): ?>
                            <p class="text-muted italic">Aucun avis pour l'instant. Soyez le premier !</p>
                        <?php else: ?>
                            <?php foreach($comments as $c): ?>
                                <div class="p-3 mb-3 bg-dark rounded border-start border-warning border-4">
                                    <strong class="text-info"><?= $c->author ?> :</strong>
                                    <p class="mb-0 mt-1"><?= $c->content ?></p>
                                    <small class="text-muted" style="font-size: 10px;"><?= $c->created_at ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <hr class="border-secondary">

                    <!-- Formulaire pour commenter -->
                    <form action="index.php?url=ad/comment" method="POST" class="mt-auto">
                        <input type="hidden" name="ad_id" value="<?= $ad->id ?>">
                        <div class="mb-3">
                            <label class="form-label small">Ton expertise marketing :</label>
                            <textarea name="content" class="form-control bg-dark text-white border-0" rows="3" placeholder="Écris ton avis..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold">ENVOYER MON AVIS</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>
</html>