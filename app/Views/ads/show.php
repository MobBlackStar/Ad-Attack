<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        
        <!-- 🖼️ The Giant Ad -->
        <div class="col-md-7">
            <div class="card bg-secondary border-0 shadow-lg">
                <img src="<?= BASE_URL ?>/assets/uploads/<?= $ad->image_path ?>" class="img-fluid rounded-top" alt="Ad">
                <div class="card-body text-center">
                    <h2 class="text-warning italic">"<?= $ad->slogan ?>"</h2>
                    <p class="text-info small">By Agency #<?= $ad->agency_id ?></p>
                </div>
            </div>
            <div class="mt-4">
                <a href="<?= BASE_URL ?>/ad/index" class="btn btn-outline-light">← Gallery</a>
            </div>
        </div>

        <!-- 💬 The Comment Section -->
        <div class="col-md-5">
            <div class="card bg-secondary p-4 shadow-lg h-100">
                <h3 class="text-warning mb-4">Golden Book</h3>
                
                <!-- TEAM: Loop through the comments we got from the Manager -->
                 <div class="comment-box mb-4" style="max-height: 400px; overflow-y: auto;">
                    <?php if(empty($comments)): ?>
                        <p class="text-muted italic">No feedback yet. Be the first to judge!</p>
                          <?php else: ?>
                     <?php foreach($comments as $c): ?>
                         <div class="p-3 mb-3 bg-dark rounded border-start border-warning border-4">
                              <!-- Use the 'author' name we joined in the Model -->
                                 <strong class="text-info"><?= htmlspecialchars($c->author) ?> :</strong>
                        <p class="mb-0 mt-1"><?= htmlspecialchars($c->content) ?></p>
                     <small class="text-muted" style="font-size: 10px;"><?= $c->created_at ?></small>
                 </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

                <hr class="border-secondary">

                <!-- Comment Form -->
                <form action="<?= BASE_URL ?>/ad/comment" method="POST" class="mt-auto">
                    <input type="hidden" name="ad_id" value="<?= $ad->id ?>">
                    <div class="mb-3">
                        <label class="form-label small text-warning">Your Marketing Expertise:</label>
                        <textarea name="content" class="form-control bg-dark text-white border-0" rows="3" placeholder="Write your review..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold">POST FEEDBACK</button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>