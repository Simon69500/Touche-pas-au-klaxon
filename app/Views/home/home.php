<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/index.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Accueil - Touche pas au klaxon</title>
</head>
<body>
    <!-- Header -->
    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <!-- Contenu principal -->
    <main class="container mt-5">

        <!-- Titre -->
        <?php if(isset($_SESSION['user'])): ?>
            <h1 class="m-4">Trajets proposés</h1>
        <?php else: ?>
            <h1 class="m-4">Pour obtenir plus d'information sur un trajet, veuillez vous connecter</h1>
        <?php endif; ?>

        <!-- Tableau des trajets -->
        <?php $baseUrl = \App\Config\Config::baseUrl(); ?>
        <?php $trips = $trips ?? []; ?>

        <table class="table table-striped p-3">
            <thead>
                <tr class="text-center">
                    <th scope="col">Départ</th>
                    <th scope="col">Date départ</th>
                    <th scope="col">Heure départ</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Date arrivée</th>
                    <th scope="col">Heure arrivée</th>
                    <th scope="col">Places dispo</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($trips as $trip): ?>
                    <?php $trip = $trip ?? []; ?>
                    <tr class="text-center">
                        <td><?= htmlspecialchars($trip['ville_depart'] ?? '-') ?></td>
                        <td><?= isset($trip['date_heure_depart']) ? date('Y-m-d', strtotime($trip['date_heure_depart'])) : '-' ?></td>
                        <td><?= isset($trip['date_heure_depart']) ? date('H:i', strtotime($trip['date_heure_depart'])) : '-' ?></td>
                        <td><?= htmlspecialchars($trip['ville_arrivee'] ?? '-') ?></td>
                        <td><?= isset($trip['date_heure_arrive']) ? date('Y-m-d', strtotime($trip['date_heure_arrive'])) : '-' ?></td>
                        <td><?= isset($trip['date_heure_arrive']) ? date('H:i', strtotime($trip['date_heure_arrive'])) : '-' ?></td>
                        <td><?= htmlspecialchars($trip['places_dispo'] ?? 'N/A') ?></td>
                        <td>
                            <?php if(isset($_SESSION['user'])): ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#trajetModal<?= htmlspecialchars($trip['id_trajet'] ?? 0) ?>"><i class="bi bi-eye"></i></a>
                                <?php if(($_SESSION['user']['id'] ?? 0) === ($trip['auteur_id'] ?? 0)): ?>
                                    <a href="<?= $baseUrl ?>?page=edit&id=<?= htmlspecialchars($trip['id_trajet'] ?? 0) ?>"><i class="bi bi-pencil-square"></i></a>
                                    <a href="<?= $baseUrl ?>?page=delete&id=<?= htmlspecialchars($trip['id_trajet'] ?? 0) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le trajet ?');"><i class="bi bi-trash"></i></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <?php $currentTrip = $trip; ?>
                    <?php include __DIR__ . '/../layouts/modal.php'; ?>

                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
