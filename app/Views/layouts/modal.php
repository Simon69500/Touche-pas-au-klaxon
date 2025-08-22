<?php if(isset($trip)): ?>
<!-- Modal -->
<div class="modal fade" id="trajetModal<?= $trip['id_trajet'] ?>" tabindex="-1" aria-labelledby="trajetModalLabel<?= $trip['id_trajet'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Header -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="trajetModalLabel<?= $trip['id_trajet'] ?>">
                     Trajet  de <?= htmlspecialchars($trip['ville_depart'] ?? '-') ?>
                     à <?= htmlspecialchars($trip['ville_arrivee'] ?? '-') ?>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <p><strong class="p-2">Conducteur :</strong><?= htmlspecialchars(($trip['prenom'] ?? 'Inconnu') . ' ' . ($trip['nom'] ?? '')) ?></p>
                <p><strong class="p-2">Téléphone :</strong><?= htmlspecialchars($trip['telephone'] ?? '-') ?></p>
                <p><strong class="p-2">Email :</strong><?= htmlspecialchars($trip['email'] ?? '-') ?></p>
                <p><strong class="p-2">Places totals :</strong><?= htmlspecialchars($trip['places_dispo'] ?? 'N/A') ?></p>
            </div>

             <!-- Footer -->    
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                
                <!-- Si utilisateur = auteur -->
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === (int)($trip['auteur_id'] ?? 0)): ?>
                    <a href="<?= $baseUrl ?>?page=edit&id=<?= htmlspecialchars($trip['id_trajet'] ?? 0) ?>" class="btn btn-secondary">Modifier</a>
                    <a href="<?= $baseUrl ?>?page=delete&id=<?= htmlspecialchars($trip['id_trajet'] ?? 0) ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le trajet ?');">Supprimer</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
