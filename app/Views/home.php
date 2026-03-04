<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-4 mb-5">
    
    <!-- HEADER SECTION -->
    <div class="text-center mb-5">
        <h1 class="display-2 fw-bold text-white font-monospace" style="text-shadow: 0 0 20px #00f0ff; letter-spacing: 2px;">AD-ATTACK</h1>
        <p class="lead text-info font-monospace tracking-widest text-uppercase">
            SYSTEM STATUS: <span class="text-success fw-bold">ONLINE</span>
        </p>
    </div>

    <!-- MAIN GRID: 8 Columns Left, 4 Columns Right -->
    <div class="row g-4 align-items-stretch">
        
        <!-- LEFT MONITOR: SYSTEM LOG & TELEMETRY -->
        <div class="col-lg-8">
            <div class="card bg-dark border-info h-100 shadow-lg" style="border-width: 1px; box-shadow: 0 0 25px rgba(0, 240, 255, 0.05);">
                
                <div class="card-header bg-transparent border-info text-info font-monospace p-3" style="background: rgba(0, 240, 255, 0.05) !important;">
                    > root@ad-attack:~$ status_check --full
                </div>
                
                <div class="card-body p-4 d-flex flex-column">
                    <!-- The Checklist -->
                    <div class="text-light font-monospace fs-5 mb-4">
                        <p class="mb-2"><span class="text-success fw-bold me-2">✔</span> Protocol [MVC_ENGINE] ......... <span class="text-secondary">ACTIVE</span></p>
                        <p class="mb-2"><span class="text-success fw-bold me-2">✔</span> Module [AUTH_GUARD] ........... <span class="text-secondary">SECURED</span></p>
                        <p class="mb-2"><span class="text-success fw-bold me-2">✔</span> Module [BLIND_VOTE] ........... <span class="text-secondary">LISTENING</span></p>
                        <p class="mb-0"><span class="text-success fw-bold me-2">✔</span> Module [CULTIVATION] .......... <span class="text-warning">RANKING</span></p>
                    </div>
                    
                    <hr class="border-info opacity-25 my-4">
                    
                    <p class="text-warning font-monospace fs-6">> INCOMING TRANSMISSION: The arena is open. Agencies are competing for the Open Heaven Realm.</p>
                    
                    <!-- Action Buttons -->
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <a href="<?= BASE_URL ?>/brief" class="btn btn-warning fw-bold w-100 py-3 shadow-sm" style="letter-spacing: 1px;">ACQUIRE TARGET</a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= BASE_URL ?>/ad" class="btn btn-outline-info fw-bold w-100 py-3 shadow-sm" style="letter-spacing: 1px;">VIEW WARFARE</a>
                        </div>
                    </div>

                    <!-- TEAM: FEDI'S TELEMETRY PANEL -->
                    <!-- This pushes itself to the bottom of the card smoothly -->
                    <div class="mt-auto pt-4">
                        <div class="p-4 rounded" style="background: #090b10; border: 1px solid rgba(0, 240, 255, 0.2); box-shadow: inset 0 0 15px rgba(0,0,0,0.8);">
                            <h6 class="text-info mb-3 font-monospace fw-bold">> SERVER_TELEMETRY_</h6>
                            
                            <div class="row text-light font-monospace small g-4">
                                <!-- Data Column 1 -->
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-between border-bottom border-secondary pb-2 mb-2">
                                        <span class="opacity-75">Active Briefs:</span> 
                                        <span class="text-warning fw-bold fs-6"><?= $totalBriefs ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between border-bottom border-secondary pb-2">
                                        <span class="opacity-75">Live Campaigns:</span> 
                                        <span class="text-warning fw-bold fs-6"><?= $totalAds ?></span>
                                    </div>
                                </div>
                                <!-- Data Column 2 -->
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-between border-bottom border-secondary pb-2 mb-2">
                                        <span class="opacity-75">Network Ping:</span> 
                                        <span class="text-success fw-bold">12ms</span>
                                    </div>
                                    <div class="d-flex justify-content-between border-bottom border-secondary pb-2">
                                        <span class="opacity-75">Encryption:</span> 
                                        <span class="text-success fw-bold">AES-256</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-info font-monospace d-flex align-items-center">
                                <span class="spinner-grow spinner-grow-sm text-warning me-3" role="status"></span>
                                <span class="tracking-widest">AWAITING OPERATIVE INPUT_</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT MONITOR: CULTIVATION LORE -->
        <div class="col-lg-4">
            <div class="card bg-dark border-secondary h-100 shadow-lg" style="border-radius: 4px;">
                <div class="card-header bg-transparent border-secondary text-info fw-bold text-center font-monospace" style="letter-spacing: 2px;">
                    [ CYBER-MERIDIAN PATHWAY ]
                </div>
                <div class="card-body p-4 d-flex align-items-center">
                    
                    <!-- The Vertical 'Qi' Line -->
                    <div class="position-relative w-100" style="border-left: 2px dashed rgba(0, 240, 255, 0.3); margin-left: 10px; padding-left: 25px;">
                        
                        <!-- Open Heaven -->
                        <div class="position-relative mb-4">
                            <span class="position-absolute top-50 start-0 translate-middle p-2 bg-warning rounded-circle shadow-lg" style="box-shadow: 0 0 15px #f3e600 !important; margin-left: -25px;"></span>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h5 class="mb-0 text-warning fw-bold" style="text-shadow: 0 0 8px rgba(243, 230, 0, 0.8);">🌌 OPEN HEAVEN</h5>
                                <span class="badge bg-dark border border-warning text-warning font-monospace">100+ QI</span>
                            </div>
                            <small class="text-muted font-monospace" style="font-size: 0.75rem;">Apex of the Dao. Reality bends to your marketing will.</small>
                        </div>

                        <!-- Emperor -->
                        <div class="position-relative mb-4">
                            <span class="position-absolute top-50 start-0 translate-middle p-2 bg-danger rounded-circle" style="box-shadow: 0 0 10px #ff003c !important; margin-left: -25px;"></span>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 text-danger fw-bold">👑 EMPEROR</h6>
                                <span class="badge bg-dark border border-danger text-danger font-monospace">50+ QI</span>
                            </div>
                            <small class="text-muted font-monospace" style="font-size: 0.75rem;">A ruler of the digital landscape. Campaigns are legendary.</small>
                        </div>

                        <!-- Dao Source -->
                        <div class="position-relative mb-4">
                            <span class="position-absolute top-50 start-0 translate-middle p-2 bg-info rounded-circle" style="box-shadow: 0 0 10px #00f0ff !important; margin-left: -25px;"></span>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 text-info fw-bold">⚔️ DAO SOURCE</h6>
                                <span class="badge bg-dark border border-info text-info font-monospace">30+ QI</span>
                            </div>
                            <small class="text-muted font-monospace" style="font-size: 0.75rem;">You have touched the origin of viral algorithms.</small>
                        </div>

                        <!-- Saint -->
                        <div class="position-relative mb-4">
                            <span class="position-absolute top-50 start-0 translate-middle p-2 bg-primary rounded-circle" style="margin-left: -25px;"></span>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 text-primary fw-bold">🛡️ SAINT REALM</h6>
                                <span class="badge bg-dark border border-primary text-primary font-monospace">15+ QI</span>
                            </div>
                            <small class="text-muted font-monospace" style="font-size: 0.75rem;">Your agency is respected across the server.</small>
                        </div>

                        <!-- Immortal -->
                        <div class="position-relative mb-4">
                            <span class="position-absolute top-50 start-0 translate-middle p-2 bg-success rounded-circle" style="margin-left: -25px;"></span>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 text-success fw-bold">⚡ IMMORTAL</h6>
                                <span class="badge bg-dark border border-success text-success font-monospace">5+ QI</span>
                            </div>
                            <small class="text-muted font-monospace" style="font-size: 0.75rem;">You have shed your mortal shell. The ascent begins.</small>
                        </div>

                        <!-- Tempered Body -->
                        <div class="position-relative">
                            <span class="position-absolute top-50 start-0 translate-middle p-2 bg-secondary rounded-circle" style="margin-left: -25px;"></span>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="mb-0 text-secondary fw-bold">🧱 TEMPERED BODY</h6>
                                <span class="badge bg-dark border border-secondary text-secondary font-monospace">0 QI</span>
                            </div>
                            <small class="text-muted font-monospace" style="font-size: 0.75rem;">A fragile novice stepping into the Guerrilla Arena.</small>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- TOP CULTIVATORS (Full Width Leaderboard) -->
        <div class="col-12 mt-5">
            <h4 class="text-center text-warning mb-4 font-monospace" style="letter-spacing: 2px;">🏆 CURRENT APEX LEADERS</h4>
            <div class="row g-4">
                <?php if(!empty($topAgencies)): ?>
                    <?php foreach($topAgencies as $top): ?>
                        <div class="col-md-4">
                            <div class="card bg-dark border-warning shadow-sm text-center p-3 h-100" style="border-width: 2px;">
                                <div class="card-body">
                                    <h3 class="text-white mb-2 fw-bold text-uppercase"><?= htmlspecialchars($top->name) ?></h3>
                                    <div class="mb-3">
                                        <span class="<?= $top->status['color'] ?> shadow-sm px-3 py-1 fs-6"><?= $top->status['rank'] ?></span>
                                    </div>
                                    <h1 class="mt-3 text-info fw-bold mb-0 display-4"><?= $top->total_qi ?></h1>
                                    <small class="text-muted font-monospace tracking-widest text-uppercase">Total Qi Accumulated</small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted font-monospace">No agencies have ascended yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>