<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <!-- On utilise la boussole pour trouver le CSS, peu importe l'ordinateur -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <div class="container mt-5">
        <h1 class="text-warning text-center mb-5 fw-bold" style="letter-spacing: 2px;">🖼️ THE AD EXHIBITION</h1>
        
        <div class="row justify-content-center">
            <?php if(empty($ads)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted italic">L'arène est vide... Soyez le premier à attaquer !</p>
                </div>
            <?php else: ?>
                
                <?php foreach($ads as $ad): ?>
                    <!-- TEAM : On est À L'INTÉRIEUR de la boucle, donc $ad existe ici ! -->
                    <div class="col-md-4 mb-4">
                        <div class="card bg-secondary border-0 shadow-lg h-100">
                            
                            <!-- Image avec le chemin corrigé pour localhost -->
                            <div style="height: 250px; overflow: hidden;">
                                <!-- On utilise la boussole pour aller directement dans le dossier uploads -->
<img src="<?= BASE_URL ?>/assets/uploads/<?= basename($ad->image_path) ?>" 
     class="card-img-top" 
     style="height: 250px; object-fit: cover;">
                                     class="card-img-top" 
                                     style="height: 100%; width: 100%; object-fit: cover;" 
                                     alt="Ad Image">
                            </div>
                            
                            <div class="card-body d-flex flex-column text-center">
                                <h4 class="card-title text-warning mt-2">"<?= $ad->slogan ?>"</h4>
                                <p class="card-text text-info small mb-4">By Agency #<?= $ad->agency_id ?></p>
                                
                                <div class="mt-auto">
                                    <a href="index.php?url=ad/show/<?= $ad->id ?>" class="btn btn-warning w-100 fw-bold py-2">
                                        VIEW & JUDGE
                                    </a>
                                    <!-- 🎭 BLIND VOTING SECTION -->
                                    <!-- bouton blind voting -->
                                    <!-- Fedi: I added the 'vote-btn' class for your AJAX magic! -->
                                    <div class="p-2 bg-dark rounded-pill border border-warning mb-2">
                                        <small class="text-white">
                                            Score : 
                                            <span id="score-<?= $ad->id ?>" class="text-warning fw-bold">
                                                <span style="filter: blur(5px);">88</span>
                                            </span>
                                        </small>
                                    </div>
                                     <button class="btn btn-sm btn-outline-warning w-100 vote-btn" data-id="<?= $ad->id ?>">
                                        VOTE TO REVEAL
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>

        <div class="text-center mt-5 mb-5">
            <a href="index.php?url=ad/submit" class="btn btn-lg btn-warning px-5 fw-bold shadow">POST NEW AD</a>
            <br>
            <a href="index.php?url=home" class="text-muted mt-3 d-inline-block text-decoration-none">← Back to Lobby</a>
        </div>
    </div>

</body>
</html>
<!-- TEAM - Sarra : Je connecte officiellement le script AJAX de Fedi ! -->
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>