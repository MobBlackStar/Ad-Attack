<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-4">
    <!-- TEAM: The Top Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-warning fw-bold font-monospace">📢 THE BRIEFING ROOM</h1>
        <a href="<?= BASE_URL ?>/brief/create" class="btn btn-warning shadow-lg fw-bold rounded-pill px-4">+ POST NEW BRIEF</a>
    </div>

    <!-- TEAM: The "Telepathic" Control Panel -->
    <form id="filterForm" action="<?= BASE_URL ?>/brief" method="GET" class="card bg-dark p-3 mb-5 border border-secondary shadow-lg" style="border-radius: 15px;">
        <div class="row g-3 align-items-center">
            
            <!-- 1. Auto-Search Bar -->
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-secondary border-0 text-warning">🔍</span>
                    <input type="text" name="search" id="searchInput" class="form-control bg-secondary text-white border-0" 
                           placeholder="Type to search missions..." value="<?= htmlspecialchars($currentSearch ?? '') ?>">
                </div>
            </div>

            <!-- 2. Category Dropdown -->
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-secondary border-0 text-info">📂</span>
                    <select name="cat" class="form-select bg-secondary text-white border-0" onchange="this.form.submit()">
                        <option value="All" <?= ($currentCategory == 'All') ? 'selected' : '' ?>>All Sectors</option>
                        <option value="Tech" <?= ($currentCategory == 'Tech') ? 'selected' : '' ?>>Tech</option>
                        <option value="Food" <?= ($currentCategory == 'Food') ? 'selected' : '' ?>>Food</option>
                        <option value="Absurd" <?= ($currentCategory == 'Absurd') ? 'selected' : '' ?>>Absurd</option>
                        <option value="Luxury" <?= ($currentCategory == 'Luxury') ? 'selected' : '' ?>>Luxury</option>
                    </select>
                </div>
            </div>

            <!-- 3. Sort Buttons (Sleek Pills) -->
            <div class="col-md-3">
                <div class="btn-group w-100 shadow-sm" role="group">
                    <input type="radio" class="btn-check" name="sort" value="newest" id="sortNew" <?= ($currentSort == 'newest') ? 'checked' : '' ?> onchange="this.form.submit()">
                    <label class="btn btn-outline-info" for="sortNew">📅 Newest</label>

                    <input type="radio" class="btn-check" name="sort" value="trending" id="sortTrend" <?= ($currentSort == 'trending') ? 'checked' : '' ?> onchange="this.form.submit()">
                    <label class="btn btn-outline-warning" for="sortTrend">🔥 Trending</label>
                </div>
            </div>
            
            <!-- Notice: The "Update" button is GONE. The JS handles it now! -->
        </div>
    </form>

    <!-- TEAM: Flash Messages -->
    <?php if($msg = \App\Core\Session::flash('success')): ?>
        <div class="alert alert-success border-0 mb-4 rounded-pill text-center fw-bold shadow-sm"><?= $msg ?></div>
    <?php endif; ?>
    <?php if($msg = \App\Core\Session::flash('message')): ?>
        <div class="alert alert-info border-0 mb-4 rounded-pill text-center fw-bold shadow-sm"><?= $msg ?></div>
    <?php endif; ?>

    <!-- The Briefs Grid -->
    <div class="row">
        <?php if(empty($briefs)): ?>
            <div class="col-12 text-center py-5">
                <h3 class="text-muted font-monospace">No missions detected in this sector.</h3>
                <a href="<?= BASE_URL ?>/brief" class="btn btn-outline-warning mt-3 rounded-pill px-4">Reset Radar</a>
            </div>
        <?php else: ?>
            <?php foreach($briefs as $brief): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary h-100 border-0 shadow-lg position-relative" style="border-radius: 15px; overflow: hidden;">
                        
                        <!-- Delete Button (Owner Only) -->
                        <?php if($brief->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1): ?>
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 shadow" 
                                    style="z-index: 10; border-radius: 50%; width: 35px; height: 35px;"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal-<?= $brief->id ?>">🗑️</button>
                            
                             <!-- Modal included here -->
                             <div class="modal fade" id="deleteModal-<?= $brief->id ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-white border-danger shadow-lg">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-danger fw-bold">Confirm Incineration</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center p-4">
                                            <h1 class="display-1">🔥</h1>
                                            <p class="mt-3">Are you sure you want to completely erase the mission <strong>"<?= htmlspecialchars($brief->title) ?>"</strong>?</p>
                                        </div>
                                        <div class="modal-footer border-secondary justify-content-center">
                                            <button type="button" class="btn btn-outline-light px-4" data-bs-dismiss="modal">Cancel</button>
                                            <a href="<?= BASE_URL ?>/brief/delete/<?= $brief->id ?>" class="btn btn-danger fw-bold px-4 shadow">ERASE FOREVER</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php $briefImg = !empty($brief->image) ? basename($brief->image) : ''; ?>
                        <img src="<?= $briefImg ? BASE_URL . '/assets/uploads/' . htmlspecialchars($briefImg) : '' ?>" class="card-img-top" style="height: 220px; object-fit: cover;" alt="<?= htmlspecialchars($brief->title ?? 'Brief') ?>"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'220\'%3E%3Crect fill=\'%23333\' width=\'400\' height=\'220\'/%3E%3Ctext fill=\'%23666\' x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'14\'%3ENo image%3C/text%3E%3C/svg%3E';">
                        
                        <div class="card-body d-flex flex-column bg-dark">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-secondary text-warning px-3 py-2 rounded-pill"><?= $brief->category ?></span>
                                <!-- Show Vote Count if Trending -->
                                <?php if($currentSort == 'trending'): ?>
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">🔥 <?= $brief->vote_count ?? 0 ?> Qi</span>
                                <?php endif; ?>
                            </div>
                            <h4 class="card-title text-white fw-bold"><?= htmlspecialchars($brief->title) ?></h4>
                            <p class="card-text text-light small opacity-75 mb-4"><?= substr(htmlspecialchars($brief->description), 0, 85) ?>...</p>
                            
                            <div class="mt-auto d-flex gap-2">
                                <a href="<?= BASE_URL ?>/brief/show/<?= $brief->id ?>" class="btn btn-warning w-100 fw-bold shadow-sm">VIEW BRIEF</a>
                                <?php if($brief->agency_id == \App\Core\Auth::id() || \App\Core\Auth::id() == 1): ?>
                                    <a href="<?= BASE_URL ?>/brief/edit/<?= $brief->id ?>" class="btn btn-info shadow-sm" title="Edit Brief">✏️</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- ARCHITECT MAGIC: The Telepathic Search Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('searchInput');
    const filterForm = document.getElementById('filterForm');

    // 1. The Focus Restoration Trick
    // When the page reloads, put the blinking cursor back at the end of the text
    if (searchInput.value) {
        const val = searchInput.value;
        searchInput.focus();
        searchInput.value = ''; 
        searchInput.value = val;
    }

    // 2. The Debouncer (Waits 800ms after you stop typing to submit)
    let typingTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            filterForm.submit();
        }, 800);
    });
});
</script>
 <!-- THE PAGINATION BAR -->
    <?php if($totalPages > 1): ?>
        <nav aria-label="Brief navigation" class="mt-5">
            <ul class="pagination justify-content-center">
                
                <!-- Previous Button -->
                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link bg-dark text-warning border-secondary" 
                       href="<?= BASE_URL ?>/brief?cat=<?= $currentCategory ?>&sort=<?= $currentSort ?>&search=<?= urlencode($currentSearch) ?>&page=<?= $currentPage - 1 ?>">
                       Previous
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                        <a class="page-link <?= ($currentPage == $i) ? 'bg-warning text-dark border-warning fw-bold' : 'bg-dark text-light border-secondary' ?>" 
                           href="<?= BASE_URL ?>/brief?cat=<?= $currentCategory ?>&sort=<?= $currentSort ?>&search=<?= urlencode($currentSearch) ?>&page=<?= $i ?>">
                           <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Button -->
                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link bg-dark text-warning border-secondary" 
                       href="<?= BASE_URL ?>/brief?cat=<?= $currentCategory ?>&sort=<?= $currentSort ?>&search=<?= urlencode($currentSearch) ?>&page=<?= $currentPage + 1 ?>">
                       Next
                    </a>
                </li>

            </ul>
        </nav>
    <?php endif; ?>
<?php require '../app/Views/partials/footer.php'; ?>