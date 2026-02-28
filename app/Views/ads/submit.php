<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <!-- TEAM : On utilise le CSS de Bootstrap que Fedi a installé -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <h2 class="text-warning text-center mb-4">🎨 Ad-Attack : Zone de Submission</h2>

                <!-- TEAM - Sarra : C'est ici que l'action se passe. 
                     J'ai mis l'adresse complète pour être sûre que ça ne bug pas. -->
                <form action="index.php?url=ad/store" method="POST" enctype="multipart/form-data" class="card bg-secondary p-4 shadow">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">1. Ton Slogan Publicitaire</label>
                        <input type="text" name="slogan" class="form-control" placeholder="Ex: Une brique, un futur." required>
                        <small class="text-info">Trouve une phrase qui claque !</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">2. Ton Montage (Image)</label>
                        <input type="file" name="ad_image" class="form-control" required>
                        <small class="text-info">Format JPG ou PNG uniquement.</small>
                    </div>

                    <hr>

                    <!-- TEAM : Le bouton de validation -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning btn-lg fw-bold">
                            LANCER L'ATTAQUE !
                        </button>
                    </div>

                </form>

                <div class="mt-4 text-center">
                    <a href="index.php?url=home" class="text-decoration-none text-muted">← Retour à l'accueil</a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>