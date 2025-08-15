<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
        <div class="login-container">
            <h2>Connexion</h2>

            <!-- Gestion des erreurs  -->
            <?php if (!empty($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="/login">
                <fieldset>
                    <legend>Formulaire de connexion</legend>

                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email :</label>
                        <input type="email" name="email" id="inputEmail" class="form-control" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div>
                        <label for="inputMdp" class="form-label">Mot de passe :</label>
                        <input type="password" name="password" id="inputMdp" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Se connecter</button>

                </fieldset>
            </form>
        </div>
    </main>
</body>
</html>