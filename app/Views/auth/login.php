<?php require '../app/Views/partials/header.php'; ?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-5">
        
        <!-- RITEJ : SECURITY SPEAKER (For Error Messages) -->
        <?php $error = \App\Core\Session::flash('error'); ?>
        <?php if($error): ?>
            <div class="alert alert-danger text-center fw-bold shadow-sm mb-4">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php $success = \App\Core\Session::flash('message'); ?>
        <?php if($success): ?>
            <div class="alert alert-success text-center fw-bold shadow-sm mb-4">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <div class="card bg-secondary text-white shadow-lg border-0" style="border-radius: 1rem;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="text-info fw-bolder">AGENCY LOGIN</h2>
                    <p class="text-light opacity-75">Identify yourself to enter the Arena.</p>
                </div>
                
                <form action="<?= BASE_URL ?>/auth/authenticate" method="POST">
                    
                    <!-- SECURITY: CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">

                    <div class="form-floating mb-3 text-dark">
                        <input type="email" name="email" id="logEmail" class="form-control fw-bold" placeholder="Email" required>
                        <label for="logEmail">Professional Email</label>
                    </div>

                    <!-- PASSWORD WITH MAGIC EYE -->
                    <div class="input-group mb-4">
                        <div class="form-floating flex-grow-1">
                            <input type="password" name="password" id="logPass" class="form-control fw-bold border-end-0" placeholder="Password" style="border-top-right-radius: 0; border-bottom-right-radius: 0;" required>
                            <label for="logPass" class="text-dark">Secret Password</label>
                        </div>
                        <button class="btn btn-outline-secondary border-start-0 bg-white text-dark" type="button" onclick="toggleLoginPass()" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                            👁️
                        </button>
                    </div>

                    <button type="submit" class="btn btn-info btn-lg w-100 fw-bold rounded-pill shadow-sm">
                        ENTER THE ARENA
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>/auth/register" class="text-warning text-decoration-none">
                        <small>No Agency yet? Register here.</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RITEJ: Simple script to toggle password visibility -->
<script>
    function toggleLoginPass() {
        var x = document.getElementById("logPass");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

<?php require '../app/Views/partials/footer.php'; ?>