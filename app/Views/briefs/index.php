<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/Ad-Attack/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="text-warning fw-bold">📢 THE BRIEFING ROOM</h1>
        <a href="/Ad-Attack/public/index.php?url=brief/create" class="btn btn-warning shadow">+ Post New Brief</a>
    </div>

    <!-- Success Message -->
    <?php if($msg = \App\Core\Session::flash('success')): ?>
        <div class="alert alert-success border-0 shadow-sm"><?= $msg ?></div>
    <?php endif; ?>

    <div class="row">
        <?php if(empty($briefs)): ?>
            <div class="col-12 text-center mt-5">
                <p class="text-muted">The Arena is empty. Be the first to launch a challenge!</p>
            </div>
        <?php else: ?>
            <?php foreach($briefs as $brief): ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-secondary h-100 border-0 shadow-lg">
                        <!-- We point to our physical uploads folder -->
                        <img src="/Ad-Attack/public/assets/uploads/<?= $brief->image ?>" 
                             class="card-img-top" style="height: 200px; object-fit: cover;" alt="Product">
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-warning text-dark"><?= $brief->category ?></span>
                                <small class="text-light opacity-50 float-end">Ends: <?= $brief->deadline ?></small>
                            </div>
                            <h5 class="card-title text-white"><?= $brief->title ?></h5>
                            <p class="card-text text-light opacity-75 small">
                                <?= substr($brief->description, 0, 80) ?>...
                            </p>
                            <a href="#" class="btn btn-outline-warning mt-auto w-100">View & Submit Ad</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>