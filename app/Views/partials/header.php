<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- If the Manager (Controller) gives us a title, use it. Otherwise, say Ad-Attack -->
    <title><?= $title ?? 'Ad-Attack' ?></title>
    <!-- We load Bootstrap once, right here, for the whole team to use -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

<!-- This is the Main Navigation Menu. We build it once, it shows on every page. -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary mb-4">
    <div class="container">
        <a class="navbar-brand text-warning fw-bold" href="/home">Ad-Attack</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <!-- Everyone can click to see challenges -->
                <li class="nav-item"><a class="nav-link" href="/briefs">Challenges</a></li>
                
                <!-- If the user has an ID Badge (Logged In), show Logout -->
                <?php if(\App\Core\Session::isLoggedIn()): ?>
                    <li class="nav-item"><a class="nav-link text-danger" href="/auth/logout">Logout</a></li>
                <!-- If they have no badge, show Login -->
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/auth/login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- This holds the actual page content. The team will put their code AFTER this. -->
<div class="container">
    
    <!-- If the system has a temporary message (like "Wrong Password"), show it here -->
    <?php $msg = \App\Core\Session::flash('message'); if($msg): ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>