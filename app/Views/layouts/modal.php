
 <!-- Modal -->
<div class="modal fade" id="trajetModal<?= $trip['id_trajet'] ?>" tabindex="-1" aria-labelledby="trajetModalLabel<?= $trip['id_trajet'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="trajetModalLabel<?= $trip['id_trajet'] ?>">
                     Trajet n°<?= htmlspecialchars($trip['id_trajet']) ?>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                    <p><strong class="p-2">Conducteur :</strong><?= htmlspecialchars($trip['prenom']. ' ' . $trip['nom'] ?? 'Inconnu') ?></p>
                    <p><strong class="p-2">Téléphone :</strong><?= htmlspecialchars($trip['telephone'] ?? '-') ?></p>
                    <p><strong class="p-2">Email :</strong><?= htmlspecialchars($trip['email'] ?? '-') ?></p>
                    <p><strong class="p-2">Places totals :</strong><?= htmlspecialchars($trip['places_dispo'] ?? 'N/A') ?></p>
                </div>

             <!-- Footer -->    
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                
                <!-- Si utilisateur = auteur -->
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === (int)$trip['auteur_id']): ?>
                    <a href="/trips/edit?id=<?= $trip['id_trajet'] ?>" class="btn btn-secondary">Modifier</a>
                    <a href="/trips/delete?id=<?= $trip['id_trajet'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le trajet ?');">Supprimer</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
