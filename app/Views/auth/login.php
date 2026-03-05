<?php require '../app/Views/partials/header.php'; ?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <!-- RITEJ : Le Haut-Parleur pour les alertes de sécurité (Bouclier & Erreurs) -->
        <?php $error = \App\Core\Session::flash('error'); ?>
        <?php if($error): ?>
            <div class="alert alert-danger text-center fw-bold shadow-sm mb-4">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <div class="card bg-secondary text-white shadow-lg border-0" style="border-radius: 1rem;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="text-info fw-bolder">CONNEXION</h2>
                    <p class="text-light opacity-75">Identify yourself to enter the Arena</p>
                </div>
                
                <form action="<?= BASE_URL ?>/auth/authenticate" method="POST">
                    
                    <!-- SECURITY: The CSRF Shield -->
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">

                    <div class="form-floating mb-3 text-dark">
                        <input type="email" name="email" id="logEmail" class="form-control fw-bold" placeholder="Email" required>
                        <label for="logEmail">Professional Email</label>
                    </div>

                    <div class="form-floating mb-4 text-dark">
                        <input type="password" name="password" id="logPass" class="form-control fw-bold" placeholder="Mot de passe" required>
                        <label for="logPass">Secret password</label>
                    </div>

                    <button type="submit" class="btn btn-info btn-lg w-100 fw-bold rounded-pill shadow-sm">
                        ENTER
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>/auth/register" class="text-warning text-decoration-none">
                        <small>No Agency yet? Register here</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>