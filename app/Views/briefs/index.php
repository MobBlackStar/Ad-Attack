<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-4">
    <!-- TEAM: The Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="text-warning fw-bold">📢 THE BRIEFING ROOM</h1>
        <a href="<?= BASE_URL ?>/brief/create" class="btn btn-warning shadow-lg fw-bold">+ Post New Brief</a>
    </div>

    <!-- TEAM: The Category Filter -->

    <div class="mb-4">
    <a href="<?= BASE_URL ?>/brief?sort=newest" class="btn btn-sm <?= ($currentSort == 'newest') ? 'btn-warning' : 'btn-outline-warning' ?>">Newest</a>
    <a href="<?= BASE_URL ?>/brief?sort=trending" class="btn btn-sm <?= ($currentSort == 'trending') ? 'btn-warning' : 'btn-outline-warning' ?>">🔥 Trending</a>
</div>
    <form action="<?= BASE_URL ?>/brief" method="GET" class="row g-2 mb-5 bg-secondary p-3 rounded shadow-sm">
        <div class="col-md-3">
            <select name="category" class="form-select bg-dark text-white border-0">
                <option value="All" <?= ($currentCategory ?? '') == 'All' ? 'selected' : '' ?>>All Categories</option>
                <option value="Tech" <?= ($currentCategory ?? '') == 'Tech' ? 'selected' : '' ?>>Tech</option>
                <option value="Food" <?= ($currentCategory ?? '') == 'Food' ? 'selected' : '' ?>>Food</option>
                <option value="Absurd" <?= ($currentCategory ?? '') == 'Absurd' ? 'selected' : '' ?>>Absurd</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-warning w-100">Apply Filter</button>
        </div>
    </form>

    <!-- TEAM: Flash Messages (Error/Success) -->
    <?php if($msg = \App\Core\Session::flash('success')): ?>
        <div class="alert alert-success border-0 mb-4"><?= $msg ?></div>
    <?php endif; ?>
    <?php if($msg = \App\Core\Session::flash('message')): ?>
        <div class="alert alert-info border-0 mb-4"><?= $msg ?></div>
    <?php endif; ?>

    <div class="row">
        <?php if(empty($briefs)): ?>
            <div class="col-12 text-center text-muted">No challenges found in this category.</div>
        <?php else: ?>
            <?php foreach($briefs as $brief): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary h-100 border-0 shadow">
                        <img src="<?= BASE_URL ?>/assets/uploads/<?= $brief->image ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-dark text-warning mb-2 w-25"><?= $brief->category ?></span>
                            <h5 class="card-title text-white"><?= htmlspecialchars($brief->title) ?></h5>
                            <p class="card-text text-light small opacity-75"><?= substr(htmlspecialchars($brief->description), 0, 80) ?>...</p>
                            
                            <!-- THE ACTION BOX -->
                            <div class="mt-auto pt-3 border-top border-dark">
                                <a href="<?= BASE_URL ?>/brief/show/<?= $brief->id ?>" class="btn btn-warning w-100 mb-2 fw-bold">View & Submit</a>
                                
                                <!-- MOATAZ: HERE IS THE SHREDDER (Delete) AND EDIT BUTTONS! -->
                                <!-- SECURITY: Only show these if the logged-in user OWNS the brief (or is Admin) -->
                                <?php if(\App\Core\Auth::id() == $brief->agency_id || \App\Core\Auth::id() == 1): ?>
                                    <div class="d-flex gap-2">
                                        <a href="<?= BASE_URL ?>/brief/edit/<?= $brief->id ?>" class="btn btn-sm btn-info w-50">Edit</a>
                                        
                                        <!-- The Modal Trigger (Replaces the ugly confirm popup) -->
                                        <button type="button" class="btn btn-sm btn-danger w-50" data-bs-toggle="modal" data-bs-target="#deleteModal-<?= $brief->id ?>">
                                            Delete
                                        </button>
                                    </div>

                                    <!-- THE MODAL (Hidden by default) -->
                                    <div class="modal fade" id="deleteModal-<?= $brief->id ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark text-white border-warning">
                                                <div class="modal-header border-secondary">
                                                    <h5 class="modal-title text-warning">Confirm Shredding</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Team: Are you sure you want to <strong>SHRED</strong> "<?= htmlspecialchars($brief->title) ?>"?
                                                </div>
                                                <div class="modal-footer border-secondary">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="<?= BASE_URL ?>/brief/delete/<?= $brief->id ?>" class="btn btn-danger fw-bold">Yes, Shred It</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>