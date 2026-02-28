<?php 
// TEAM: We load the Master Header so we get the Dark Mode & Navbar automatically.
require '../app/Views/partials/header.php'; 
?>

<div class="container mt-5 text-center">
    <h1 class="display-3 text-warning fw-bold">Ad-Attack</h1>
    <p class="lead">The Guerrilla Marketing Arena.</p>
    <hr class="bg-secondary mb-5">
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-secondary text-white shadow-lg">
                <div class="card-body">
                    <h3 class="card-title">✅ Engine Online</h3>
                    <p class="card-text">Team, the MVC Architecture is 100% operational.</p>
                    <p class="text-info">The Receptionist (Router) is successfully talking to the Managers (Controllers).</p>
                    
                    <p class="mt-4 border-top pt-3">
                        <strong>Gatekeeper:</strong> Start working on AuthController.<br>
                        <strong>Client:</strong> Check the Briefing Room.<br>
                        <strong>Creative:</strong> Start working on AdController.
                    </p>
                    <a href="<?= BASE_URL ?>/brief" class="btn btn-warning mt-3">Go to Briefing Room</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>