<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-white">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                
                <!-- FEDI'S MAGIC: This shows the flash message if they type a bad password -->
                <?php $error = App\Core\Session::flash('error'); ?>
                <?php if($error): ?>
                    <div class="alert alert-danger text-center fw-bold">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <?php $success = App\Core\Session::flash('success'); ?>
                <?php if($success): ?>
                    <div class="alert alert-success text-center fw-bold">
                        <?= $success ?>
                    </div>
                <?php endif; ?>

                <div class="card bg-secondary text-white shadow-lg border-0">
                    <div class="card-body p-5">
                        <h2 class="text-info text-center fw-bold mb-4">CONNEXION</h2>
                        
                        <!-- Le formulaire envoie les infos au Manager (action authenticate) -->
                        <form action="<?= BASE_URL ?>/auth/authenticate" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
                            </div>
                            <button type="submit" class="btn btn-info w-100 fw-bold">ENTRER</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="<?= BASE_URL ?>/auth/register" class="text-warning">Pas encore d'Agence ? Inscrivez-vous.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>