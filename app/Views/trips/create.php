<?php
$errors = $errors ?? [];
$agences = $agences ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer son trajet</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <!-- Header -->
    <?php include __DIR__. '/../layouts/header.php'; ?>

    <main class="container mt-5">
        <div class="create-container">
            <h2>Créer votre Trajet</h2>
            
            <!-- Affiche les erreurs -->
            <?php if(!empty($errors)): ?>
            <ul class="alert alert-danger">
                <?php foreach($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            
            
            <!-- Formulaire de création de nouveau trajet -->
            <form method="POST" action="?page=create">
                <fieldset>
                    <legend>Mon nouveau trajet</legend>

                    <div class="mb-3">
                        <label for="inputAgenceDepart" class="form-label">Agence de départ :</label>
                        <select type="text" class="form-select" id="inputAgenceDepart" name="agence_depart_id" required>
                            <?php foreach($agences as $agence): ?>
                                <option value="<?= $agence['id_agence'] ?>"><?= htmlspecialchars($agence['ville']) ?></option>
                            <?php endforeach; ?>    
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="inputAgenceArrive" class="form-label">Agence d'arrivée :</label>
                        <select type="text" class="form-select" id="inputAgenceArrive" name="agence_arrive_id" required>
                            <?php foreach($agences as $agence): ?>
                                <option value="<?= $agence['id_agence'] ?>"><?= htmlspecialchars($agence['ville']) ?></option>
                            <?php endforeach; ?>    
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="inputPlacesTotal" class="form-label">Places total :</label>
                        <input type="number" class="form-control" id="inputPlacesTotal" name="places_total" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="inputDateDepart" class="form-label">Date et heure de départ :</label>
                        <input type="datetime-local" class="form-control" id="inputDateDepart" name="date_heure_depart" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="inputDateArrive" class="form-label">Date et heure d'arrivée' :</label>
                        <input type="datetime-local" class="form-control" id="inputDateArrive" name="date_heure_arrive" required>
                    </div>
    
                        <input type="hidden" name="contact_id" value="<?= $_SESSION['user']['id']?>">
                        <input type="hidden" name="auteur_id" value="<?= $_SESSION['user']['id'] ?>">    

                    <button type="submit" class="btn btn-primary">Enregistrer le trajet</button>
                </fieldset>
            </form>
        </div>
    </main>

         <!-- Footer -->
    <?php include __DIR__. '/../layouts/footer.php'; ?>
</body>
</html>