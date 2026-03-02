<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-warning text-center mb-5 font-monospace">🖼️ THE AD EXHIBITION</h1>
    
    <div class="row">
        <?php if(empty($ads)): ?>
            <div class="col-12 text-center">
                <p class="text-muted italic">The arena is empty... Be the first to attack!</p>
            </div>
        <?php else: ?>
            <?php foreach($ads as $ad): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary shadow-lg border-0 h-100">
                        <!-- Fedi: Fixed image path using BASE_URL -->
                        <img src="<?= BASE_URL ?>/assets/uploads/<?= $ad->image_path ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column text-center">
                            <h4 class="text-warning mb-3">"<?= $ad->slogan ?>"</h4>
                            <p class="small text-info mt-auto">By Agency #<?= $ad->agency_id ?></p>
                            <hr class="border-secondary">
                            <a href="<?= BASE_URL ?>/ad/show/<?= $ad->id ?>" class="btn btn-warning w-100 fw-bold">View & Judge</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- TEAM: Blind Voting preview. The Architect will add the AJAX magic later! -->
    <div class="mt-4 text-center">
        <span class="badge bg-dark text-warning p-2 fs-6 border border-warning">Current Leader: ??? (Vote to Reveal)</span>
    </div>

    <div class="text-center mt-5 mb-5">
        <a href="<?= BASE_URL ?>/brief" class="btn btn-outline-warning">← Back to Briefs</a>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>