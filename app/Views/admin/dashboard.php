<?php require '../app/Views/partials/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-danger fw-bold text-center mb-5">👁️ THE PANOPTICON</h1>
    
    <div class="row">
        <!-- THE AGENCY REGISTRY -->
        <div class="col-md-12">
            <div class="card bg-dark border-danger shadow-lg">
                <div class="card-header bg-danger text-white fw-bold">All Registered Agencies</div>
                <div class="card-body">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Agency Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($agencies as $agency): ?>
                                <tr>
                                    <td><?= $agency->id ?></td>
                                    <td class="text-warning"><?= htmlspecialchars($agency->name) ?></td>
                                    <td><?= htmlspecialchars($agency->email) ?></td>
                                    <td>
                                        <!-- Only show 'Ban' if it's not the Overlord (ID 1) -->
                                        <?php if($agency->id != 1): ?>
                                            <a href="<?= BASE_URL ?>/admin/banUser/<?= $agency->id ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Ban this agency permanently?');">Ban</a>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Overlord</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <p class="text-muted mt-3 small">Architect Note: More admin controls (Brief/Ad moderation) coming soon.</p>
        </div>
    </div>
</div>

<?php require '../app/Views/partials/footer.php'; ?>