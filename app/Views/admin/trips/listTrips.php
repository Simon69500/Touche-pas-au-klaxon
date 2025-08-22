<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= \App\Config\Config::baseUrl() ?>/public/assets/css/main.css">

    <title>Liste des trajets</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <?php include __DIR__ . '/../../layouts/header.php'; ?>

    <main class="container mt-4">

        <div class="d-flex flex-row align-items-center">
            <a class="iconBS" href="index.php?controller=admin&action=dashboard"><i class="bi bi-arrow-bar-left fs-2"></i></a>
            <h1 class="text-center p-3">Liste des trajets</h1>
         </div>   
              
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash_message']['type']) ?> mt-3" role="alert">
            <?= htmlspecialchars($_SESSION['flash_message']['message']) ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

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
                        <th>Contact</th>                        
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
                            <td><?= htmlspecialchars(strval(($trip['prenom'] ) . ' ' . ($trip['nom'] ))) ?></td>
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
