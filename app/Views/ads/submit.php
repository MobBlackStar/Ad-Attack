<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <h2 class="text-warning text-center mb-4">🎨 Launch an Ad-Attack</h2>

            <!-- TEAM: The Form uses the Master Router URL and enctype for files! -->
            <form action="<?= BASE_URL ?>/ad/store" method="POST" enctype="multipart/form-data" class="card bg-secondary p-4 shadow">
                
                <!-- SECURITY: Architect's CSRF Shield -->
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">
                <!-- We need to know WHICH brief we are answering -->
                <input type="hidden" name="brief_id" value="<?= $brief_id ?>">

                <div class="mb-4">
                    <label class="form-label fw-bold">1. Your Killer Slogan</label>
                    <input type="text" name="slogan" class="form-control" placeholder="e.g. A brick for the future." required>
                    <small class="text-info">Make it punchy!</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">2. Your Photoshopped Masterpiece</label>
                    <input type="file" name="ad_image" class="form-control" accept="image/*" required>
                    <small class="text-info">JPG or PNG formats only.</small>
                </div>

                <hr>

                <div class="d-grid">
                    <button type="submit" class="btn btn-warning btn-lg fw-bold">
                        SUBMIT AD 🚀
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <a href="<?= BASE_URL ?>/brief" class="text-decoration-none text-muted">← Back to Briefs</a>
            </div>

        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>