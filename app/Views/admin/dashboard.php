<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="text-danger fw-bold font-monospace display-4" style="text-shadow: 0 0 15px #ff003c;">👁️ THE PANOPTICON</h1>
        <p class="text-secondary font-monospace">Authorized Personnel Only // Level 5 Clearance</p>
    </div>
    
    <div class="row">
        <!-- THE AGENCY REGISTRY -->
        <div class="col-md-12">
            <div class="card bg-dark border-danger shadow-lg" style="box-shadow: 0 0 30px rgba(255, 0, 60, 0.1);">
                <div class="card-header bg-danger text-white fw-bold d-flex justify-content-between align-items-center">
                    <span>AGENCY DATABASE</span>
                    <span class="badge bg-black text-danger"><?= count($agencies) ?> ENTITIES</span>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0 align-middle" style="border-color: #333;">
                            <thead class="text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Identity</th>
                                    <th>Agency Name</th>
                                    <th>Contact Frequency</th>
                                    <th class="text-end pe-4">Status / Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($agencies as $agency): ?>
                                    <tr style="height: 80px;">
                                        <!-- ID -->
                                        <td class="ps-4 text-secondary font-monospace">#<?= str_pad($agency->id, 3, '0', STR_PAD_LEFT) ?></td>
                                        
                                        <!-- AVATAR (Robohash Magic) -->
                                        <td>
                                            <img src="https://robohash.org/<?= $agency->id ?>?set=set1&size=100x100" 
                                                 alt="Avatar" 
                                                 class="rounded-circle border border-secondary p-1"
                                                 style="width: 50px; height: 50px; background: #000;">
                                        </td>

                                        <!-- NAME -->
                                        <td>
                                            <span class="fw-bold text-light"><?= htmlspecialchars($agency->name) ?></span>
                                        </td>

                                        <!-- EMAIL -->
                                        <td class="text-info font-monospace small">
                                            <?= htmlspecialchars($agency->email) ?>
                                        </td>

                                        <!-- ACTIONS -->
                                        <td class="text-end pe-4">
                                            <?php if($agency->id != 1): ?>
                                                <a href="<?= BASE_URL ?>/admin/banUser/<?= $agency->id ?>" 
                                                   class="btn btn-sm btn-outline-danger font-monospace" 
                                                   style="letter-spacing: 1px;"
                                                   onclick="return confirm('⚠️ CRITICAL WARNING ⚠️\n\nAre you sure you want to PERMANENTLY BANISH this agency from the Ad-Attack Arena?\n\nThis cannot be undone.');">
                                                   🚫 BAN
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-warning text-dark border border-warning shadow-sm px-3 py-2">
                                                    👑 OVERLORD
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-3 text-center">
                <p class="text-muted small font-monospace">
                    System Log: Monitoring all active connections...
                </p>
            </div>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>