<?php require VIEW_PATH . '/partials/header.php'; ?>

<div class="container mt-4">
    <!-- TEAM: The Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="text-warning fw-bold">📢 THE BRIEFING ROOM</h1>
        <a href="<?= BASE_URL ?>/brief/create" class="btn btn-warning shadow-lg fw-bold">+ Post New Brief</a>
    </div>

    <!-- TEAM: The Category Filter -->
    <form action="<?= BASE_URL ?>/brief/index" method="GET" class="row g-2 mb-5 bg-secondary p-3 rounded shadow-sm">
        <div class="col-md-3">
            <select name="category" class="form-select bg-dark text-white border-0">
                <option value="All">All Categories</option>
                <option value="Tech">Tech</option>
                <option value="Food">Food</option>
                <option value="Absurd">Absurd</option>
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
                                <div class="d-flex gap-2">
                                    <a href="<?= BASE_URL ?>/brief/edit/<?= $brief->id ?>" class="btn btn-sm btn-info w-50">Edit</a>
                                    <!-- Delete uses a confirmation popup for safety -->
                                    <a href="<?= BASE_URL ?>/brief/delete/<?= $brief->id ?>" 
                                       class="btn btn-sm btn-danger w-50" 
                                       onclick="return confirm('Team: Are you sure you want to SHRED this challenge?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require VIEW_PATH . '/partials/footer.php'; ?>