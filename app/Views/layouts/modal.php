<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Information du trajet</title>
</head>
<body>
    <main>
                <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Launch static backdrop modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="trajetModal"<?= $strip['id_trajet'] ?> tabindex="-1" aria-labelledby="trajetModalLabel<?= $trip['id_trajet'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="trajetModalLabel<? $trip['id_trajet'] ?>">
                     Trajet n°<?= htmlspecialchars($trip['id_trajet']) ?>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <?php if(!empty($trips)): ?>
                    <p><strong>Conducteur :</strong><?= htmlspecialchars($trip['auteur_id']) ?></p>
                    <p><strong>Téléphone :</strong><?= htmlspecialchars($trip['telephone']) ?></p>
                    <p><strong>Email :</strong><?= htmlspecialchars($trip['email']) ?></p>
                    <p><strong>Places totals :</strong><?= htmlspecialchars($trip['places_total']) ?></p>
                    <?php endif; ?>
                </div>

             <!-- Footer -->    
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                
                <!-- Si utilisateur = auteur -->
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $trip[ $id_auteur]): ?>
                    <a href="/trips/edit?id=<?= $trip['id_trajet'] ?>" class="btn btn-secondary">Modifier</a>
                    <a href="/trips/delete?id=<?= $trip['id_trajet'] ?>" class="btn btn-danger" onclick="('Êtes-vous sûr de vouloir supprimer le trajet ?');">Supprimer</a>
                <?php endif; ?>
            </div>
            </div>
        </div>
        </div>
    </main>
</body>
</html>