<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le trajet</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
        <div class="edit-container">
            <h2>Modifier votre trajet</h2>

            <!-- Réafficher le formulaire avec les messages d’erreurs si la validation échoue. -->
            <?php if(!empty($errors)): ?>
                <ul class="alert alert-danger">
                    <?php foreach($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?> 
            
            <!-- Formulaire de modification du trajet seulement modifiable par le créateur  -->
            <form action="/trips/update?id=<?= $trip['id_trajet'] ?>" method="POST">
                <fieldset>
                    <legend>Trajet</legend>

                    <div class="mb-3">
                        <label for="inputAgenceDepart" class="form-label">Agence de départ :</label>
                        <select class="form-select" name="agence_depart_id" id="inputAgenceDepart" required>
                            <?php foreach($agences as $agence): ?>
                                <option value="<?= $agence['id_agence']  ?>"<?= $agence['id_agence'] == $trip['agence_depart_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agence['ville']) ?>
                                </option>
                            <?php endforeach; ?>         
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="inputAgenceArrive" class="form-label">Agence d'arrivée' :</label>
                        <select class="form-select" name="agence_arrive_id" id="inputAgenceArrive" required>
                            <?php foreach($agences as $agence): ?>
                                <option value="<?= $agence['id_agence']  ?>"<?= $agence['id_agence'] == $trip['agence_arrive_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agence['ville']) ?>
                                </option>
                            <?php endforeach; ?>         
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="inputDateDepart" class="form-label">Date et heure de départ :</label>
                        <input class="form-control" type="datetime-local" id="inputDateDepart" name="date_heure_depart" 
                               value="<?= date('Y-m-d\TH:i', strtotime($trip['date_heure_depart'])) ?>" required>        
                    </div>

                    <div class="mb-3">
                        <label for="inputDateArrive" class="form-label">Date et heure de d'arrivée' :</label>
                        <input class="form-control" type="datetime-local" id="inputDateArrive" name="date_heure_arrive" 
                               value="<?= date('Y-m-d\TH:i', strtotime($trip['date_heure_arrive'])) ?>" required>        
                    </div>

                    <button type="submit" class="btn btn-primary">Modifier le trajet</button>

                    <?php if($trip['auteur_id'] == $_SESSION['user']['id']): ?>
                        <a href="/trips/delete?id=<?= $trip['id_trajet'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?'); ">
                            Supprimer
                        </a>
                    <?php endif; ?>

                </fieldset>
            </form> 
        </div>
    </main>
</body>
</html>