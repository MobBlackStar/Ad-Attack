<?php 
// TEAM: We load the Master Header for the Dark Mode theme and Navbar.
require '../app/Views/partials/header.php'; 
?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-2 text-warning fw-bold">AD-ATTACK</h1>
        <p class="lead text-info font-monospace">The Digital Colosseum of Guerrilla Marketing</p>
    </div>

    <div class="row g-4">
        <!-- ARENA STATUS -->
        <div class="col-md-8">
            <div class="card bg-secondary text-white border-0 shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <h3 class="text-warning fw-bold mb-4">🔥 ARENA STATUS: OPERATIONAL</h3>
                    <p class="mb-4">The factory engine is running at 100% capacity. Agencies are currently competing to ascend the Martial Peak through creative warfare.</p>
                    
                    <div class="bg-dark p-4 rounded border-start border-warning border-4 mb-4">
                        <h6 class="text-info text-uppercase small">Architect's Log: Phase 4</h6>
                        <ul class="list-unstyled mb-0 small mt-2">
                            <li class="mb-2">✅ <strong>Security:</strong> CSRF Handshakes and XSS Shields active.</li>
                            <li class="mb-2">✅ <strong>Logic:</strong> AJAX Instant Voting & Blind Scoring deployed.</li>
                            <li class="mb-0">✅ <strong>Lore:</strong> Martial Peak Cultivation System integrated.</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-3">
                        <a href="<?= BASE_URL ?>/brief" class="btn btn-warning btn-lg fw-bold px-4 shadow">🎯 BROWSE BRIEFS</a>
                        <a href="<?= BASE_URL ?>/ad" class="btn btn-outline-light btn-lg px-4">🖼️ VIEW GALLERY</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CULTIVATION LORE (Explain the Ranks to the Prof) -->
        <div class="col-md-4">
            <div class="card bg-dark border-secondary text-white shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-body">
                    <h5 class="text-warning fw-bold border-bottom border-secondary pb-2 mb-3">RANKING SYSTEM</h5>
                    <div class="small">
                        <p class="mb-2"><span class="badge bg-warning text-dark me-2">Open Heaven</span> Master of the Dao.</p>
                        <p class="mb-2"><span class="badge bg-danger me-2">Emperor</span> Peak of Marketing.</p>
                        <p class="mb-2"><span class="badge bg-info text-dark me-2">Dao Source</span> Skilled Strategist.</p>
                        <p class="mb-2"><span class="badge bg-primary me-2">Saint</span> Proven Creative.</p>
                        <p class="mb-2"><span class="badge bg-success me-2">Immortal</span> Rising Talent.</p>
                        <p class="mb-0"><span class="badge bg-secondary me-2">Tempered</span> New Recruit.</p>
                    </div>
                    <hr class="border-secondary">
                    <p class="text-muted extra-small">Note: Rank is calculated based on total Qi (Votes) received in the Exhibition.</p>
                </div>
            </div>
        </div>

        <!-- TOP CULTIVATORS (Mini Leaderboard) -->
        <div class="col-12 mt-4">
            <h3 class="text-center text-warning mb-4 font-monospace">🏆 CURRENT APEX LEADERS</h3>
            <div class="row">
                <?php if(!empty($topAgencies)): ?>
                    <?php foreach($topAgencies as $top): ?>
                        <div class="col-md-4">
                            <div class="card bg-secondary border-0 shadow-sm text-center">
                                <div class="card-body">
                                    <h5 class="text-white mb-1"><?= htmlspecialchars($top->name) ?></h5>
                                    <span class="<?= $top->status['color'] ?> shadow-sm"><?= $top->status['rank'] ?></span>
                                    <p class="mt-2 text-info small mb-0"><?= $top->total_qi ?> Total Qi</p>
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