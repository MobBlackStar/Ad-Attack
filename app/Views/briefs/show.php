<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <!-- Left Column: The Image -->
        <div class="col-md-6">
            <div class="card bg-secondary border-0 shadow-lg">
                <img src="<?= BASE_URL ?>/assets/uploads/<?= $brief->image ?>" 
                     class="img-fluid rounded" alt="Product">
            </div>
        </div>

        <!-- Right Column: The Details -->
        <div class="col-md-6">
            <span class="badge bg-warning text-dark mb-2"><?= $brief->category ?></span>
            <h1 class="display-4 text-white fw-bold"><?= $brief->title ?></h1>
            <p class="text-white opacity-50">Deadline: <?= $brief->deadline ?></p>
            
            <hr class="bg-light">
            
            <h4 class="text-warning">The Mission:</h4>
            <p class="lead text-light"><?= nl2br($brief->description) ?></p>

            <div class="mt-5">
                <!-- This button will link to Sarra's AdController later -->
                <a href="<?= BASE_URL ?>/ad/submit/<?= $brief->id ?>" class="btn btn-lg btn-primary w-100 mb-3 shadow">
                    🎨 Submit My Design
                </a>
                <a href="<?= BASE_URL ?>/brief" class="btn btn-outline-light">Back to List</a>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>