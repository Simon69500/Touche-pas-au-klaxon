<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Liste des trajets</title>
</head>
<body>
    <!-- Header -->
    <?php include __DIR__ . '/../../layouts/header.php'; ?>

    <main class="container mt-4">
        <a href="index.php?controller=admin&action=dashboard" class="btn btn-primary m-3">Tableau de bord</a>
        
        <!-- Trajets -->
        <div id="trips">
            <?php $trips = $trips ?? []; ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Départ</th>
                        <th>Date départ</th>
                        <th>Heure départ</th>
                        <th>Destination</th>
                        <th>Date arrivée</th>
                        <th>Heure arrivée</th>
                        <th>Places dispo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(empty($trips)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Aucun trajet disponible</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($trips as $trip): ?>
                        <tr>
                            <td><?= htmlspecialchars($trip['ville_depart'] ?? '-') ?></td>
                            <td><?= isset($trip['date_heure_depart']) ? date('Y-m-d', strtotime($trip['date_heure_depart'])) : '-' ?></td>
                            <td><?= isset($trip['date_heure_depart']) ? date('H:i', strtotime($trip['date_heure_depart'])) : '-' ?></td>
                            <td><?= htmlspecialchars($trip['ville_arrivee'] ?? '-') ?></td>
                            <td><?= isset($trip['date_heure_arrive']) ? date('Y-m-d', strtotime($trip['date_heure_arrive'])) : '-' ?></td>
                            <td><?= isset($trip['date_heure_arrive']) ? date('H:i', strtotime($trip['date_heure_arrive'])) : '-' ?></td>
                            <td><?= htmlspecialchars($trip['places_dispo'] ?? '-') ?></td>
                            <td>
                                <a href="index.php?controller=admin&action=deleteTrip&id=<?= $trip['id_trajet'] ?? 0 ?>"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');">
                                   <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../../layouts/footer.php'; ?>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
