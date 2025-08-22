<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= \App\Config\Config::baseUrl() ?>/public/assets/css/main.css">
</head>
<body>
    <main class="container mt-5">
        <div class="login-container">
            <div class="d-flex flex-row align-items-center">
                <a class="iconBS" href="?page=home"><i class="bi bi-arrow-bar-left fs-2"></i></a>
                <h2 class="px-3">Connexion</h2>
            </div>


            <!-- Gestion des erreurs  -->
            <?php if (!empty($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
                <form method="POST" action="?page=login">
                <fieldset>
                    <legend>Formulaire de connexion</legend>

                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email :</label>
                        <input type="email" name="email" id="inputEmail" class="form-control" aria-describedby="emailHelp" required>
                    </div>

                    <div>
                        <label for="inputMdp" class="form-label">Mot de passe :</label>
                        <input type="password" name="password" id="inputMdp" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Se connecter</button>

                </fieldset>
            </form>

            <div class="mt-3">
                <p class="fs-4">Pas encore de compte ?</p>
                <a href="?page=register" class="btn btn-outline-success">Créer un compte</a>
            </div>
        </div>
    </main>
</body>
</html>