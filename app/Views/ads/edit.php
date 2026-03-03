<?php require '../app/Views/partials/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <h2 class="text-warning text-center mb-4 fw-bold">✏️ EDIT CAMPAIGN</h2>

        <form action="<?= BASE_URL ?>/ad/update/<?= $ad->id ?>" method="POST" class="card bg-secondary p-4 shadow-lg border-0">
            <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">

            <div class="mb-4">
                <label class="form-label text-info small">Update Your Slogan</label>
                <input type="text" name="slogan" class="form-control bg-dark text-white border-0" value="<?= htmlspecialchars($ad->slogan) ?>" required>
            </div>

            <div class="alert alert-dark border-info text-info small">
                Note: The artwork (image) is permanent. You can only edit the marketing slogan.
            </div>

            <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold">SAVE CHANGES</button>
            <a href="<?= BASE_URL ?>/ad/show/<?= $ad->id ?>" class="btn btn-outline-light w-100 mt-2">Cancel</a>
        </form>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>