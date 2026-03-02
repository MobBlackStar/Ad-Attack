<?php require '../app/Views/partials/header.php'; ?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        <div class="card bg-secondary text-light shadow-lg border-0" style="border-radius: 1rem;">
            <div class="card-body p-5">
                
                <div class="text-center mb-4">
                    <h2 class="text-warning fw-bolder">AD-ATTACK</h2>
                    <p class="text-light opacity-75">Forge your Agency Identity </p>
                </div>
                  <?php $error = \App\Core\Session::flash('error'); ?>
      <!--  ZONE D'AFFICHAGE DES ERREURS -->
                    <!-- s'affichera "Password too weak" ou "Email taken" -->
                <?php if($error): ?>
                    <div class="alert alert-danger text-center fw-bold shadow-sm mb-4">
                         <?= $error ?>
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>/auth/store" method="POST">
                    <!-- securité : CSFR -->

              

                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">
                    
                    <div class="form-floating mb-3 text-dark">
                        <input type="text" class="form-control fw-bold" id="nameInput" name="name" placeholder="Agency Name" required>
                        <label for="nameInput">Agency Name</label>
                    </div>
                    
                    <div class="form-floating mb-3 text-dark">
                        <input type="email" class="form-control fw-bold" id="emailInput" name="email" placeholder="contact@agence.com" required>
                        <label for="emailInput">Professional Email</label>
                    </div>
                    
                    <div class="form-floating mb-4 text-dark">
                        <input type="password" class="form-control fw-bold" id="passwordInput" name="password" placeholder="password" required>
                        <label for="passwordInput">Secret password</label>
                        <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">
Must contain: 8 chars, 1 Uppercase, 1 Number, 1 Symbol
                    </div>
                    
                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-pill shadow-sm">
                       ENTER THE ARENA
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>/auth/login" class="text-warning text-decoration-none">
                        <small>Already have a badge? Login here</small>

                </div>

            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>