<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Ad-Attack' ?></title>
    
    <!-- Google Fonts: Cyberpunk Vibe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Scripts -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
    <script src="<?= BASE_URL ?>/assets/js/vote.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- ARCHITECT'S CSS OVERRIDE -->
    <style>
        :root { --bs-dark: #050507; --bs-secondary: #0d1117; --bs-warning: #f3e600; --bs-info: #00f0ff; --bs-danger: #ff003c; }
        body { font-family: 'Rajdhani', sans-serif; background-color: var(--bs-dark); color: #e0e6ed; background-image: linear-gradient(rgba(0, 240, 255, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(0, 240, 255, 0.03) 1px, transparent 1px); background-size: 30px 30px; }
        h1, h2, h3, h4, h5, .font-monospace { font-family: 'Share Tech Mono', monospace !important; text-transform: uppercase; }
        .card { border: 1px solid rgba(0, 240, 255, 0.2) !important; border-radius: 4px !important; box-shadow: 0 0 15px rgba(0,0,0,0.5); transition: 0.3s all ease-in-out; }
        .card:hover { border-color: var(--bs-info) !important; box-shadow: 0 0 20px rgba(0, 240, 255, 0.2); }
        .btn { border-radius: 0px !important; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; }
        .btn-warning { background-color: var(--bs-warning); color: #000; box-shadow: 0 0 10px rgba(243, 230, 0, 0.4); }
        .btn-warning:hover { background-color: #fff; box-shadow: 0 0 20px rgba(243, 230, 0, 0.8); }
        .text-warning { color: var(--bs-warning) !important; text-shadow: 0 0 5px rgba(243,230,0,0.5); }
        .text-info { color: var(--bs-info) !important; text-shadow: 0 0 5px rgba(0,240,255,0.5); }
        .text-danger { color: var(--bs-danger) !important; text-shadow: 0 0 5px rgba(255,0,60,0.5); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary mb-4 border-bottom" style="border-color: var(--bs-info) !important;">
    <div class="container">
        <a class="navbar-brand text-warning fw-bold fs-3" href="<?= BASE_URL ?>/home">⚡ AD-ATTACK</a>
        
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link text-light" href="<?= BASE_URL ?>/brief">🎯 MISSIONS</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="<?= BASE_URL ?>/ad">🖼️ EXHIBITION</a></li>
                <li class="nav-item"><a class="nav-link text-warning" href="<?= BASE_URL ?>/rankings">🏆 HALL OF FAME</a></li>
                
                <?php if(\App\Core\Session::isLoggedIn()): ?>
                    <?php if(\App\Core\Session::get('user_id') == 1): ?>
                        <li class="nav-item ms-3"><a class="nav-link text-danger fw-bold border border-danger px-2" href="<?= BASE_URL ?>/admin">OVERLORD</a></li>
                    <?php endif; ?>

                    <li class="nav-item ms-4 d-flex align-items-center">
                        <!-- ROBOHASH AVATAR IN HEADER (TEAM: uses avatar_set from session) -->
                        <img src="https://robohash.org/<?= \App\Core\Session::get('user_id') ?>?set=<?= htmlspecialchars(\App\Core\Session::get('avatar_set') ?? 'set1') ?>" 
                             alt="User" class="rounded-circle border border-info me-2" 
                             style="width: 35px; height: 35px; background: #000;">
                        
                        <span class="navbar-text text-light me-3">
                            <span class="text-info"><?= htmlspecialchars(\App\Core\Session::get('user_name')) ?></span>
                        </span>
                        <a href="<?= BASE_URL ?>/auth/profile" class="btn btn-outline-info btn-sm">SYSTEM</a>
                        <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-danger btn-sm ms-2">EXIT</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-3"><a class="nav-link btn btn-outline-warning btn-sm px-3" href="<?= BASE_URL ?>/auth/login">INITIALIZE</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php $msg = \App\Core\Session::flash('message'); if($msg): ?>
        <div class="alert alert-info border border-info shadow-lg text-center fw-bold" style="background: rgba(0,240,255,0.1); color: #00f0ff;">
            <?= $msg ?>
        </div>
    <?php endif; ?>