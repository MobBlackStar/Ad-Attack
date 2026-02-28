<?php require VIEW_PATH . '/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-warning mb-4">✏️ Edit Brief: <?= htmlspecialchars($brief->title) ?></h2>
            
            <!-- TEAM: Moataz here. This form sends data to the 'update' method in the Controller -->
            <form action="<?= BASE_URL ?>/brief/update/<?= $brief->id ?>" method="POST" class="card bg-secondary p-4 shadow">
                
                <!-- THE SHIELD: Don't forget the CSRF token Fedi asked for! -->
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">

                <div class="mb-3">
                    <label class="form-label">Challenge Title</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($brief->title) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($brief->description) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="Tech" <?= $brief->category == 'Tech' ? 'selected' : '' ?>>Tech</option>
                            <option value="Food" <?= $brief->category == 'Food' ? 'selected' : '' ?>>Food</option>
                            <option value="Absurd" <?= $brief->category == 'Absurd' ? 'selected' : '' ?>>Absurd</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="deadline" class="form-control" value="<?= date('Y-m-d', strtotime($brief->deadline)) ?>" required>
                    </div>
                </div>

                <div class="alert alert-info small">Note: To keep things simple, images cannot be changed during editing.</div>

                <button type="submit" class="btn btn-warning fw-bold w-100">SAVE CHANGES 💾</button>
            </form>
        </div>
    </div>
</div>

<?php require VIEW_PATH . '/partials/footer.php'; ?>