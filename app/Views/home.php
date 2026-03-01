<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5 text-center">
    <h1 class="display-3 text-warning fw-bold">Ad-Attack</h1>
    <p class="lead">The Guerrilla Marketing Arena.</p>
    <hr class="bg-secondary mb-5">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-secondary text-white shadow-lg border-0" style="border-radius: 1rem;">
                <div class="card-body p-5">
                    <h3 class="card-title text-success fw-bold">🔥 Phase 3 Complete: The Factory is Alive</h3>
                    <p class="card-text mt-3">Team, the Assembly Line has successfully merged. The core features are fully integrated into the Master Architecture.</p>
                    
                    <div class="text-start mt-4 bg-dark p-4 rounded border-start border-warning border-4">
                        <p class="mb-2">🛡️ <strong>Gatekeeper (Donyes):</strong> Secure Auth & CSRF Shields are locked. Real agencies can now enter.</p>
                        <p class="mb-2">📋 <strong>Client (Moataz):</strong> The Briefing Room is receiving and displaying live challenges.</p>
                        <p class="mb-2">🎨 <strong>Creative (Sarra):</strong> The Gallery is open and the Golden Book is capturing feedback.</p>
                        <p class="mb-0 text-warning">👑 <strong>Architect (Fedi):</strong> Currently forging the AJAX Blind Voting Engine and connecting the final database links.</p>
                    </div>

                    <div class="mt-5 d-flex justify-content-center gap-3">
                        <a href="<?= BASE_URL ?>/brief" class="btn btn-warning fw-bold px-4">Enter Briefing Room</a>
                        <a href="<?= BASE_URL ?>/ad" class="btn btn-outline-light px-4">View Gallery</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>