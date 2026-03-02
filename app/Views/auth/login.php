<?php require '../app/Views/partials/header.php'; ?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card bg-secondary text-white shadow-lg border-0" style="border-radius: 1rem;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="text-info fw-bolder">CONNEXION</h2>
                    <p class="text-light opacity-75">Identifiez-vous pour attaquer.</p>
                </div>
                
                <form action="<?= BASE_URL ?>/auth/authenticate" method="POST">
                    
                    <!-- SECURITY: The CSRF Shield -->
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">

                    <div class="form-floating mb-3 text-dark">
                        <input type="email" name="email" id="logEmail" class="form-control fw-bold" placeholder="Email" required>
                        <label for="logEmail">Email Professionnel</label>
                    </div>

                    <div class="form-floating mb-4 text-dark">
                        <input type="password" name="password" id="logPass" class="form-control fw-bold" placeholder="Mot de passe" required>
                        <label for="logPass">Mot de passe secret</label>
                    </div>

                    <button type="submit" class="btn btn-info btn-lg w-100 fw-bold rounded-pill shadow-sm">
                        ENTRER
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>/auth/register" class="text-warning text-decoration-none">
                        <small>Pas encore d'Agence ? Inscrivez-vous.</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>