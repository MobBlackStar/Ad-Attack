<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-3 text-warning fw-bold font-monospace" style="text-shadow: 0 0 20px #f3e600;">🏆 THE APEX</h1>
        <p class="lead text-info font-monospace">The most powerful Agencies in the Arena.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if(empty($leaders)): ?>
                <div class="text-center py-5 bg-dark border border-secondary shadow">
                    <h3 class="text-muted font-monospace">The leaderboard is empty.</h3>
                    <p>Votes must be cast before the rankings appear.</p>
                </div>
            <?php else: ?>
                <?php foreach($leaders as $index => $leader): ?>
                    <!-- Cyberpunk styling for the Leaderboard Cards -->
                    <div class="card bg-dark border-secondary mb-4 shadow-lg position-relative overflow-hidden" style="border-radius: 15px;">
                        
                        <!-- Subtle background glow based on rank -->
                        <?php $glow = ($index == 0) ? '#f3e600' : (($index == 1) ? '#C0C0C0' : '#cd7f32'); ?>
                        <div style="position: absolute; top: 0; left: 0; width: 5px; height: 100%; background: <?= $glow ?>; box-shadow: 0 0 15px <?= $glow ?>;"></div>

                        <div class="card-body d-flex align-items-center p-4 ms-3">
                            
                            <!-- The Rank Number (#1, #2, #3) -->
                            <h1 class="display-4 fw-bold me-4 mb-0" style="color: <?= $glow ?>;">#<?= $index + 1 ?></h1>
                            
                            <!-- Robohash Avatar (TEAM: each agency's chosen style) -->
                            <img src="https://robohash.org/<?= $leader->id ?>?set=<?= htmlspecialchars($leader->avatar_set ?? 'set1') ?>&size=100x100" 
                                 class="rounded-circle border border-secondary me-4"
                                 style="width: 80px; height: 80px; background: #111;">

                            <!-- Agency Info -->
                            <div class="flex-grow-1">
                                <h3 class="mb-1 text-white fw-bold font-monospace text-uppercase"><?= htmlspecialchars($leader->name) ?></h3>
                                <!-- The Cultivation Badge -->
                                <span class="<?= $leader->status['color'] ?> shadow-sm px-3 py-1 fs-6">
                                    <?= $leader->status['rank'] ?>
                                </span>
                            </div>

                            <!-- Total Qi (Votes) -->
                            <div class="text-end border-start border-secondary ps-4">
                                <h2 class="mb-0 text-info fw-bold font-monospace"><?= $leader->total_qi ?></h2>
                                <small class="text-uppercase text-light opacity-50 font-monospace">Total Qi</small>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>