<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- TEAM: Using Fedi's BASE_URL for perfect paths -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">

    <!-- TEAM: The Quick Navigation Bar -->
    <nav class="navbar navbar-dark bg-secondary mb-5 shadow-sm">
        <div class="container">
            <a class="navbar-brand text-warning fw-bold" href="<?= BASE_URL ?>/home">← Back to Arena</a>
        </div>
    </nav>

    <div class="container">
        
        <!-- FLASH MESSAGES: The Manager's Sticky Notes -->
        <?php $msg = \App\Core\Session::flash('message'); if($msg): ?>
            <div class="alert alert-success text-center fw-bold shadow-sm mb-4"><?= $msg ?></div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- MAIN COLUMN: Agency Identity -->
            <div class="col-md-8">
                <div class="card bg-secondary text-light shadow-lg border-0" style="border-radius: 1rem;">
                    <div class="card-body p-5">
                        
                        <div class="d-flex align-items-center mb-4">
                            <!-- The Avatar Slot -->
                            <div class="bg-dark rounded-circle d-flex justify-content-center align-items-center me-4 shadow" style="width: 100px; height: 100px; border: 4px solid #ffc107;">
                                <span style="font-size: 3rem;">🏢</span>
                            </div>
                            <div>
                                <!-- QUIRKY NOTE: I used htmlspecialchars here to kill XSS bugs -->
                                <h2 class="fw-bold text-warning mb-0">
                                    <?= htmlspecialchars(\App\Core\Session::get('user_name')) ?>
                                </h2>
                                <span class="badge bg-info text-dark">Official Creative Agency</span>
                            </div>
                        </div>

                        <hr class="bg-light opacity-25 my-4">

                        <!-- RITEJ:Identity Management (Rename Form) -->
                        <div class="p-4 bg-dark rounded-3 border border-secondary border-opacity-25 mb-4">
                            <form action="<?= BASE_URL ?>/auth/update" method="POST">
                                <!-- 🛡️ THE SECRET STAMP (CSRF): Fixes the Invalid Handshake error! -->
                                <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">
                                
                                <label class="text-info small fw-bold text-uppercase mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">
                                    Rename Your Agency
                                </label>
                                <div class="d-flex gap-2">
                                    <input type="text" name="name" 
                                           class="form-control form-control-sm bg-secondary text-white border-0" 
                                           value="<?= htmlspecialchars(\App\Core\Session::get('user_name')) ?>" required>
                                    <button type="submit" class="btn btn-info btn-sm fw-bold px-3">Update</button>
                                </div>
                            </form>
                        </div>

                        <h5 class="text-info mt-4">Agency Statistics</h5>
                        <p class="text-light opacity-75">
                            Completed challenges and reputation points earned will appear here soon as Moataz and Sarra finish their sections!
                        </p>
                    </div>
                </div>
            </div>

            <!-- SIDE COLUMN: Settings & Danger -->
            <div class="col-md-4">
                
                <!-- LOGOUT CARD -->
                <div class="card bg-secondary border-0 shadow-sm mb-4" style="border-radius: 1rem;">
                    <div class="card-body p-4 text-center">
                        <p class="small opacity-75">Finished for today?</p>
                        <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-outline-light w-100 rounded-pill fw-bold">Sign Out</a>
                    </div>
                </div>

                <!-- DANGER ZONE: Mandatory Task -->
                <div class="card bg-dark border border-danger shadow-lg" style="border-radius: 1rem;">
                    <div class="card-body p-4">
                        <h5 class="text-danger fw-bold border-bottom border-danger pb-2 text-uppercase" style="font-size: 0.9rem;">Danger Zone</h5>
                        <p class="small text-light opacity-50 mt-3">
                            Deleting your agency is irreversible. All your data will be permanently removed.
                        </p>

                        <form action="<?= BASE_URL ?>/auth/deleteAccount" method="POST">
                            <!-- 🛡️ CSRF TOKEN: Also needed for the Delete button! -->
                            <input type="hidden" name="csrf_token" value="<?= \App\Core\Session::generateCSRF(); ?>">
                            
                            <button type="submit" class="btn btn-danger w-100 fw-bold mt-2 rounded-pill shadow-sm" 
                                    onclick="return confirm('Are you absolutely sure you want to destroy your agency? This cannot be undone.');">
                                DELETE AGENCY
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
</html>