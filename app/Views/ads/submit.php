<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <h2 class="text-warning text-center mb-4 fw-bold">🎨 LAUNCH AN AD-ATTACK</h2>

            <form action="<?= BASE_URL ?>/ad/store" method="POST" enctype="multipart/form-data" class="card bg-secondary p-4 shadow-lg border-0">
                <input type="hidden" name="brief_id" value="<?= $brief_id ?>">
                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">

                <div class="mb-4">
                    <label class="form-label fw-bold">1. Your Killer Slogan</label>
                    <input type="text" name="slogan" class="form-control bg-dark text-white border-0" placeholder="e.g. A brick for the future." required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">2. Your Masterpiece (Image)</label>
                    <input type="file" name="ad_image" class="form-control bg-dark text-white border-0" accept="image/*">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">3. Or use an External Link (Image URL)</label>
                    <input type="url" name="external_link" class="form-control bg-dark text-white border-0" placeholder="https://example.com/image.jpg">
                    <div class="form-text text-light opacity-75">Upload a file OR paste a direct image link.</div>
                </div>

                <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-pill">
                    SUBMIT TO GALLERY 🚀
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="<?= BASE_URL ?>/brief" class="text-decoration-none text-muted">← Back to Briefs</a>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>