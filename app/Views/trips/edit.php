<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le trajet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">    
    <link rel="stylesheet" href="<?= \App\Config\Config::baseUrl() ?>/public/assets/css/main.css">        
</head>
<body>
<main class="container mt-5">
    <div class="edit-container">
            <div class="d-flex flex-row align-items-center">
                <a class="iconBS" href="?page=home"><i class="bi bi-arrow-bar-left fs-2"></i></a>
                <h2>Modifier votre trajet</h2>
            </div>        

        <!-- Affichage des erreurs de validation si présentes -->
        <?php $errors = $errors ?? []; ?>
        <?php if (!empty($errors)): ?>
            <ul class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars((string)$error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?> 

        <?php 
        // Initialisation sûre des variables pour éviter les warnings PHPStan
        $trip = $trip ?? [
            'id_trajet' => 0,
            'agence_depart_id' => 0,
            'agence_arrive_id' => 0,
            'places_total' => 0,
            'date_heure_depart' => '',
            'date_heure_arrive' => '',
            'auteur_id' => 0,
        ]; 
        $agences = $agences ?? [];
        ?>

        <!-- Formulaire de modification d'un trajet -->
        <form action="?page=edit&id=<?= (int)$trip['id_trajet'] ?>" method="POST">
            <fieldset>
                <legend>Trajet</legend>

                <!-- Sélection de l'agence de départ -->
                <div class="mb-3">
                    <label for="inputAgenceDepart" class="form-label">Agence de départ :</label>
                    <select class="form-select" name="agence_depart_id" id="inputAgenceDepart" required>
                        <?php foreach ($agences as $agence): ?>
                            <option value="<?= (int)($agence['id_agence'] ?? 0) ?>"
                                <?= (isset($trip['agence_depart_id']) && $agence['id_agence'] == $trip['agence_depart_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars((string)($agence['ville'] ?? '')) ?>
                            </option>
                        <?php endforeach; ?>         
                    </select>
                </div>

                <!-- Sélection de l'agence d'arrivée -->
                <div class="mb-3">
                    <label for="inputAgenceArrive" class="form-label">Agence d'arrivée :</label>
                    <select class="form-select" name="agence_arrive_id" id="inputAgenceArrive" required>
                        <?php foreach ($agences as $agence): ?>
                            <option value="<?= (int)($agence['id_agence'] ?? 0) ?>"
                                <?= (isset($trip['agence_arrive_id']) && $agence['id_agence'] == $trip['agence_arrive_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars((string)($agence['ville'] ?? '')) ?>
                            </option>
                        <?php endforeach; ?>         
                    </select>
                </div>

                <!-- Nombre de places -->
                <div class="mb-3">
                    <label for="inputPlacesTotal" class="form-label">Places total :</label>
                    <input type="number" class="form-control" id="inputPlacesTotal" name="places_total" 
                           value="<?= htmlspecialchars((string)($trip['places_total'] ?? 0)) ?>" required>
                </div>
                
                <!-- Date et heure de départ -->
                <div class="mb-3">
                    <label for="inputDateDepart" class="form-label">Date et heure de départ :</label>
                    <input class="form-control" type="datetime-local" id="inputDateDepart" name="date_heure_depart" 
                           value="<?= !empty($trip['date_heure_depart']) ? date('Y-m-d\TH:i', strtotime($trip['date_heure_depart'])) : '' ?>" required>        
                </div>

                <!-- Date et heure d'arrivée -->
                <div class="mb-3">
                    <label for="inputDateArrive" class="form-label">Date et heure d'arrivée :</label>
                    <input class="form-control" type="datetime-local" id="inputDateArrive" name="date_heure_arrive" 
                           value="<?= !empty($trip['date_heure_arrive']) ? date('Y-m-d\TH:i', strtotime($trip['date_heure_arrive'])) : '' ?>" required>        
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" class="btn btn-primary">Modifier le trajet</button>

                <!-- Lien de suppression visible uniquement pour le créateur -->
                <?php if (($trip['auteur_id'] ?? 0) === ($_SESSION['user']['id'] ?? 0)): ?>
                    <a href="?page=delete&id=<?= (int)($trip['id_trajet'] ?? 0) ?>" class="btn btn-danger" 
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');">
                        Supprimer
                    </a>
                <?php endif; ?>

            </fieldset>
        </form> 
    </div>
</main>
</body>
</html>
