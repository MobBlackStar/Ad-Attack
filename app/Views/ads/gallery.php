<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <!-- TEAM : On utilise le CSS de Fedi -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <div class="container mt-5">
        <h1 class="text-warning text-center mb-5">🖼️ L'Exposition Ad-Attack</h1>
        
        <div class="row">
            <?php if(empty($ads)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">L'arène est vide... Soyez le premier à attaquer !</p>
                </div>
            <?php else: ?>
                <?php foreach($ads as $ad): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-secondary shadow-lg border-0 h-100">
                            
                            <!-- TEAM - Sarra : On vérifie que le chemin pointe bien vers assets/uploads/ -->
                            <img src="<?= $ad->image_path ?>" class="card-img-top" alt="Peinture de l'agence" style="height: 250px; object-fit: cover;">
                            
                            <div class="card-body d-flex flex-column">
                                <!-- TEAM : J'ai enlevé le texte "text-warning" qui s'affichait en trop ici -->
                                <h5 class="card-title text-warning italic">"<?= $ad->slogan ?>"</h5>
                                <p class="card-text small text-info mt-auto">Posté par l'Agence n°<?= $ad->agency_id ?></p>
                                
                                <hr class="border-secondary">
                                
                                <a href="index.php?url=ad/show/<?= $ad->id ?>" class="btn btn-warning w-100 fw-bold">Voir & Juger</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!-- TEAM - Sarra: This is our 'Blind Voting' logic. 
     We check if the user has already voted. If not, we hide the points! -->
<div class="mt-auto">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="badge bg-dark text-warning">
            <?php 
                // TEAM: For now, it shows "???" to create mystery. 
                // Fedi will help us link the real count later!
                echo "Score: ???"; 
            ?>
        </span>
    </div>
    <button class="btn btn-warning w-100 fw-bold">Voter pour révéler</button>
</div>

        <div class="text-center mt-5 mb-5">
            <a href="index.php?url=ad/submit" class="btn btn-outline-warning">← Retour au formulaire</a>
            <a href="index.php?url=home" class="btn btn-outline-light ms-3">Accueil</a>
        </div>
    </div>

</body>
</html>