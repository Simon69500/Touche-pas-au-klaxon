<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
        <h2>Créer un compte utilisateurs</h2>

        <!-- Affichage d'une erreur si elle existe -->
         <?php if (!empty($error)): ?>
            <div class="alter alter-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Formulaire d'inscription -->
         <form method="POST" action="/register">
            <fieldset>
                <div class="mb-3">
                    <label for="inputNom" class="form-label">Nom :</label>
                    <input type="text" class="form-control" id="inputNom" name="nom" required >
                </div>

                <div class="mb-3">
                    <label for="inputPrenom" class="form-label">Prénom :</label>
                    <input type="text" class="form-control" id="inputPrenom" name="prenom" required>
                </div>

                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="inputTelephone" class="form-label">Téléphone :</label>
                    <input type="text" class="form-control" id="inputTelephone" name="telephone">
                </div>
                
                <div class="mb-3">
                    <label for="inputMdp" class="form-label">Mot de passe :</label>
                    <input type="password" class="form-control" id="inputMdp" name="password" required>
                </div>
                
                <div class="mb-3">
                    <label for="selectRole" class="form-label">Rôle :</label>
                    <select type="text" class="form-select" id="selectRole" name="role" required>
                        <option value="user">Utilisateur</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Créer le compte</button>
            </fieldset>
         </form>
    </main>
</body>
</html>