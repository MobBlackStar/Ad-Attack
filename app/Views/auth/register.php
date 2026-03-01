<?php require '../app/Views/partials/header.php'; ?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card bg-secondary text-light shadow-lg border-0" style="border-radius: 1rem;">
            <div class="card-body p-5">
                
                <div class="text-center mb-4">
                    <h2 class="text-warning fw-bolder">AD-ATTACK</h2>
                    <p class="text-light opacity-75">Forgez l'identité de votre agence.</p>
                </div>
                
                <form action="<?= BASE_URL ?>/auth/store" method="POST">
                    
                    <!-- SECURITY: The CSRF Shield -->
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">
                    
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
                    
                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-pill shadow-sm">
                        ENTRER DANS L'ARÈNE
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>/auth/login" class="text-warning text-decoration-none">
                        <small>Vous avez déjà un badge ? Connectez-vous.</small>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>