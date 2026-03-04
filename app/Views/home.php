<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-1 fw-bold text-white" style="text-shadow: 0 0 20px #00f0ff;">AD-ATTACK</h1>
        <p class="lead text-info font-monospace tracking-widest">
            SYSTEM STATUS: <span class="text-success fw-bold">ONLINE</span>
        </p>
    </div>

    <div class="row g-4">
        <!-- SYSTEM LOG (Left Column) -->
        <div class="col-md-8">
            <div class="card bg-dark border-info h-100 shadow-lg" style="border-width: 1px; box-shadow: 0 0 25px rgba(0, 240, 255, 0.1);">
                <div class="card-header bg-transparent border-info text-info font-monospace p-3">
                    > root@ad-attack:~$ status_check --full
                </div>
                <div class="card-body p-4 text-light font-monospace">
                    <p class="mb-2"><span class="text-success">✔</span> Protocol [MVC_ENGINE] ......... <span class="text-secondary">ACTIVE</span></p>
                    <p class="mb-2"><span class="text-success">✔</span> Module [AUTH_GUARD] ........... <span class="text-secondary">SECURED</span></p>
                    <p class="mb-2"><span class="text-success">✔</span> Module [BLIND_VOTE] ........... <span class="text-secondary">LISTENING</span></p>
                    <p class="mb-4"><span class="text-success">✔</span> Module [CULTIVATION] .......... <span class="text-secondary">RANKING</span></p>
                    
                    <hr class="border-secondary opacity-25">
                    
                    <p class="text-warning">>> INCOMING TRANSMISSION: The arena is open. Agencies are competing for the Open Heaven Realm.</p>
                    
                    <div class="mt-4 d-flex gap-3">
                        <a href="<?= BASE_URL ?>/brief" class="btn btn-warning fw-bold px-4 w-50">ACQUIRE TARGET</a>
                        <a href="<?= BASE_URL ?>/ad" class="btn btn-outline-info px-4 w-50">VIEW WARFARE</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- RANKING LORE (Right Column) -->
        <div class="col-md-4">
            <div class="card bg-dark border-secondary h-100 shadow-lg">
                <div class="card-header bg-transparent border-secondary text-warning fw-bold text-center">
                    CULTIVATION REALMS
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between">
                            <span class="badge bg-warning text-dark">Open Heaven</span> <small class="text-muted">100+ Qi</small>
                        </li>
                        <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between">
                            <span class="badge bg-danger">Emperor</span> <small class="text-muted">50+ Qi</small>
                        </li>
                        <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between">
                            <span class="badge bg-info text-dark">Dao Source</span> <small class="text-muted">30+ Qi</small>
                        </li>
                        <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between">
                            <span class="badge bg-primary">Saint</span> <small class="text-muted">15+ Qi</small>
                        </li>
                        <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between">
                            <span class="badge bg-success">Immortal</span> <small class="text-muted">5+ Qi</small>
                        </li>
                        <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between">
                            <span class="badge bg-secondary">Tempered</span> <small class="text-muted">0 Qi</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- TOP CULTIVATORS (Full Width) -->
        <div class="col-12 mt-4">
            <h4 class="text-center text-warning mb-4 font-monospace">🏆 CURRENT APEX LEADERS</h4>
            <div class="row">
                <?php if(!empty($topAgencies)): ?>
                    <?php foreach($topAgencies as $top): ?>
                        <div class="col-md-4">
                            <div class="card bg-dark border-warning shadow-sm text-center p-3 h-100" style="border-width: 2px;">
                                <div class="card-body">
                                    <h3 class="text-white mb-1"><?= htmlspecialchars($top->name) ?></h3>
                                    <div class="mt-2">
                                        <span class="<?= $top->status['color'] ?> shadow-sm"><?= $top->status['rank'] ?></span>
                                    </div>
                                    <p class="mt-3 text-info fw-bold mb-0 display-6"><?= $top->total_qi ?></p>
                                    <small class="text-muted">Total Qi Accumulated</small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">No agencies have ascended yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>