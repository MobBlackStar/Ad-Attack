<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Updated by Architect Fedi -->
    <title><?= $title ?? 'Ad-Attack' ?></title>
    
    <!-- THE FIX: Using BASE_URL to handle VirtualHost vs Localhost -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary mb-4">
    <div class="container">
        <a class="navbar-brand text-warning fw-bold" href="<?= BASE_URL ?>/home">Ad-Attack</a>
        
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/brief">Challenges</a></li>
                
                <?php if(\App\Core\Session::isLoggedIn()): ?>
<li class="nav-item d-flex align-items-center">
    <!-- Affiche le nom de l'agence -->
    <span class="navbar-text text-light me-3">
        Salut, <strong class="text-info"><?= \App\Core\Session::get('user_name') ?></strong>
    </span>
    <!-- Le bouton vers le profil -->
    <a href="<?= BASE_URL ?>/auth/profile" class="btn btn-info btn-sm fw-bold rounded-pill px-3">
my agent 
</a>
</li>

                    <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/auth/login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php $msg = \App\Core\Session::flash('message'); if($msg): ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>