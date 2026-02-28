<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Notice how we use the variable the Controller handed to us -->
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/Ad-Attack/public/assets/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">

    <div class="container mt-5 text-center">
        <h1 class="display-3 text-warning fw-bold">Ad-Attack</h1>
        <p class="lead">The Guerrilla Marketing Arena.</p>
        <hr class="bg-secondary mb-5">
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-secondary text-white shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title">✅ Engine Online</h3>
                        <p class="card-text">Team, the MVC Architecture is 100% operational.</p>
                        <p class="text-info">The Receptionist (Router) is successfully talking to the Managers (Controllers).</p>
                        
                        <p class="mt-4 border-top pt-3">
                            <strong>Gatekeeper:</strong> Start working on AuthController.<br>
                            <strong>Client:</strong> Start working on BriefController.<br>
                            <strong>Creative:</strong> Start working on AdController.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>