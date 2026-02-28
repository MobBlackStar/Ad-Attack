<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Pour que le site soit beau même sur téléphone portable -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <!-- LE FIX DU DÉCORATEUR : On donne l'adresse exacte pour WAMP -->
    <link rel="stylesheet" href="/Ad-Attack/public/assets/css/bootstrap.min.css">
</head>

<!-- d-flex align-items-center : Centre le formulaire verticalement au milieu de l'écran -->
<body class="bg-dark d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                
                <!-- UX God-Tier : Carte avec des bords très arrondis (radius) et une ombre douce -->
                <div class="card bg-secondary text-light shadow-lg border-0" style="border-radius: 1rem;">
                    <div class="card-body p-5">
                        
                        <div class="text-center mb-4">
                            <h2 class="text-warning fw-bolder">AD-ATTACK</h2>
                            <!-- opacity-75 = Rend le texte un peu gris/transparent pour l'élégance -->
                            <p class="text-light opacity-75">Forgez l'identité de votre agence.</p>
                        </div>
                        
                        <!-- L'adresse exacte où le Manager (AuthController) attend les données -->
                        <form action="/Ad-Attack/public/auth/store" method="POST">
                            
                            <!-- UX : Floating Labels (L'animation satisfaisante) -->
                            <!-- On met le texte en 'text-dark' pour qu'il soit lisible dans la case blanche -->
                            <div class="form-floating mb-3 text-dark">
                                <input type="text" class="form-control fw-bold" id="nameInput" name="name" placeholder="Nom de l'Agence" required>
                                <label for="nameInput">Nom de l'Agence (ex: Nova Studio)</label>
                            </div>
                            
                            <div class="form-floating mb-3 text-dark">
                                <input type="email" class="form-control fw-bold" id="emailInput" name="email" placeholder="contact@agence.com" required>
                                <label for="emailInput">Email Professionnel (ex: boss@nova.com)</label>
                            </div>
                            
                            <div class="form-floating mb-4 text-dark">
                                <input type="password" class="form-control fw-bold" id="passwordInput" name="password" placeholder="Mot de passe" required>
                                <label for="passwordInput">Mot de passe secret</label>
                            </div>
                            
                            <!-- Call To Action (Le gros bouton jaune arrondi) -->
                            <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-pill shadow-sm">
                                ENTRER DANS L'ARÈNE
                            </button>
                        </form>
                        
                        <!-- Redirection ergonomique pour ceux qui sont déjà inscrits -->
                        <div class="text-center mt-4">
                            <a href="/Ad-Attack/public/auth/login" class="text-warning text-decoration-none">
                                <small>Vous avez déjà un badge ? Connectez-vous.</small>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>