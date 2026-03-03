<?php 
// TEAM: We are using Fedi's partials now to keep our code dry and clean!
require '../app/Views/partials/header.php'; 
?>

<!-- 📢 THE GOLDEN NOTIFICATION -->
<?php 
    $notification = \App\Core\Session::flash('success') ?: \App\Core\Session::flash('message');
    if($notification): 
?>
    <div class="container mt-3" style="position: relative; z-index: 9999;">
        <div class="alert shadow-lg d-flex align-items-center" role="alert" 
             style="background: linear-gradient(90deg, #ffc107, #ffdb58); color: #000; border: 2px solid #000; border-radius: 12px; font-weight: bold;">
            <span class="me-3" style="font-size: 1.5rem;">🚀</span>
            <div><span class="text-uppercase" style="letter-spacing: 1px; opacity: 0.7;">Update :</span> <?= $notification ?></div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <h1 class="text-warning text-center mb-5 fw-bold" style="letter-spacing: 2px; font-family: 'Courier New', Courier, monospace;">
        🖼️ THE AD EXHIBITION
    </h1>
    
    <div class="row justify-content-center">
        <?php if(empty($ads)): ?>
            <div class="col-12 text-center">
                <p class="text-muted italic">The arena is empty... Be the first to attack!</p>
            </div>
        <?php else: ?>
            
            <?php foreach($ads as $ad): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary border-0 shadow-lg h-100 position-relative">
                        
                        <!-- 🗑️ THE SHREDDER -->
                        <?php if($ad->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1): ?>
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-3 shadow" 
                               style="z-index: 20; border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#shredModal<?= $ad->id ?>">
                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                 <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                               </svg>
                            </button>

                            <!-- MODAL -->
                            <div class="modal fade" id="shredModal<?= $ad->id ?>" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark border border-warning" style="border-radius: 20px;">
                                  <div class="modal-header border-0"><h5 class="modal-title text-warning fw-bold">⚠️ CRITICAL ACTION</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
                                  <div class="modal-body text-center py-4">
                                    <div class="mb-3" style="font-size: 3rem;">🔥</div>
                                    <p class="text-white fs-5">Team: Shred "<span class="text-warning"><?= htmlspecialchars($ad->slogan) ?></span>"?</p>
                                  </div>
                                  <div class="modal-footer border-0 justify-content-center pb-4">
                                    <button type="button" class="btn btn-outline-light px-4" data-bs-dismiss="modal">ABORT</button>
                                    <a href="<?= BASE_URL ?>/index.php?url=ad/delete/<?= $ad->id ?>" class="btn btn-danger px-4 fw-bold shadow">YES, SHRED IT</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                        <?php endif; ?>

                        <!-- 🖼️ Image -->
                        <div style="height: 250px; overflow: hidden;">
                            <img src="<?= BASE_URL ?>/assets/uploads/<?= basename($ad->image_path) ?>" 
                                 class="card-img-top" style="height: 100%; width: 100%; object-fit: cover;" alt="Ad">
                        </div>
                        
                        <div class="card-body d-flex flex-column text-center">
                            <h4 class="card-title text-warning mt-2">"<?= htmlspecialchars($ad->slogan) ?>"</h4>
                            <p class="card-text text-info small mb-3">By Agency #<?= $ad->agency_id ?></p>
                            
                            <div class="mt-auto">
                                <a href="<?= BASE_URL ?>/index.php?url=ad/show/<?= $ad->id ?>" class="btn btn-warning w-100 fw-bold py-2 mb-3 shadow-sm">VIEW & JUDGE</a>
                                
                                <div class="p-2 bg-dark rounded-pill border border-warning mb-2 shadow-sm">
                                    <small class="text-white">Score : 
                                        <span id="score-<?= $ad->id ?>" class="text-warning fw-bold">
                                            <?php if(isset($ad->has_voted) && $ad->has_voted): ?> 
                                                <?= $ad->vote_count ?>
                                            <?php else: ?> 
                                                <span style="filter: blur(5px);">88</span> 
                                            <?php endif; ?>
                                        </span>
                                    </small>
                                </div>
                                
                                <?php if(\App\Core\Session::isLoggedIn()): ?>
                                    <?php if(!isset($ad->has_voted) || !$ad->has_voted): ?>
                                        <button class="btn btn-sm btn-outline-warning w-100 vote-btn" data-id="<?= $ad->id ?>">VOTE TO REVEAL</button>
                                    <?php else: ?>
                                        <span class="badge bg-success w-100 py-2 shadow-sm">✅ YOU VOTED</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="btn btn-sm btn-outline-info w-100">Login to Vote</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="text-center mt-5 mb-5 border-top pt-5">
        <a href="<?= BASE_URL ?>/index.php?url=ad/submit" class="btn btn-lg btn-warning px-5 fw-bold shadow-lg">POST NEW AD</a><br>
        <a href="<?= BASE_URL ?>/index.php?url=home" class="text-muted mt-3 d-inline-block text-decoration-none">← Back to Lobby</a>
    </div>
</div>

<!-- 🧠 AJAX VOTING SCRIPT (Sarra Edition) -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".vote-btn");
    buttons.forEach(btn => {
        btn.addEventListener("click", function(e) {
            e.preventDefault();
            const id = this.getAttribute("data-id");
            const scoreSpan = document.getElementById("score-" + id);

            // ARCHITECT FIX: Using BASE_URL to ensure the path is absolute and works on Localhost!
            fetch('<?= BASE_URL ?>/index.php?url=ad/vote/' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        scoreSpan.innerHTML = data.new_score;
                        this.innerText = "VOTED";
                        this.className = "badge bg-success w-100 py-2 shadow-sm";
                        this.disabled = true;
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert("System busy. Verify your Login status!");
                });
        });
    });
});
</script>

<?php require '../app/Views/partials/footer.php'; ?>