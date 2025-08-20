<?php
// Contrôle d'accès : admin uniquement
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?page=home'); 
    exit;
}

// Récupération des données
$users = \App\Models\User::getAll();
$tripModel = new \App\Models\Trip();
$trips = $tripModel->tripAvailable(); 
$agences = \App\Models\Agence::getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

    <!-- Header -->
    <?php include __DIR__ . '/../layouts/header.php'; ?>

    <div class="container mt-5">
        <h1>Tableau de bord Administrateur</h1>

        <!-- Onglets -->
        <ul class="nav nav-tabs mb-4" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">Utilisateurs</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="trips-tab" data-bs-toggle="tab" data-bs-target="#trips" type="button" role="tab">Trajets</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="agences-tab" data-bs-toggle="tab" data-bs-target="#agences" type="button" role="tab">Agences</button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">

            <!-- Utilisateurs -->
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['nom']) ?></td>
                            <td><?= htmlspecialchars($user['prenom']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Trajets -->
            <div class="tab-pane fade" id="trips" role="tabpanel">
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
                    <?php foreach($trips as $trip): ?>
                        <tr>
                            <!-- Infos de trajet -->
                            <td><?= htmlspecialchars($trip['ville_depart']) ?></td>
                            <td><?= date('Y-m-d', strtotime($trip['date_heure_depart'])) ?></td>
                            <td><?= date('H:i', strtotime($trip['date_heure_depart'])) ?></td>
                            <td><?= htmlspecialchars($trip['ville_arrivee']) ?></td>
                            <td><?= date('Y-m-d', strtotime($trip['date_heure_arrive'])) ?></td>
                            <td><?= date('H:i', strtotime($trip['date_heure_arrive'])) ?></td>
                            <td><?= htmlspecialchars($trip['places_dispo']) ?></td>
                            <td><?= htmlspecialchars($trip['prenom']. ' ' . $trip['nom']) ?></td>
                            <td>
                                <a href="index.php?controller=admin&action=editTrip&id=<?= $trip['id_trajet'] ?>"><i class="bi bi-pencil-square"></i></a>
                                <a href="index.php?controller=admin&action=deleteTrip&id=<?= $trip['id_trajet'] ?>"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
            </div>

            <!-- Agences -->
            <div class="tab-pane fade" id="agences" role="tabpanel">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom Agence</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($agences as $agence): ?>
                        <tr>
                            <td><?= htmlspecialchars($agence['ville']) ?></td>
                            <td>
                                <a href="index.php?controller=admin&action=editAgence&id=<?= $agence['id_agence'] ?>"><i class="bi bi-pencil-square"></i></a>
                                <a href="index.php?controller=admin&action=deleteAgence&id=<?= $agence['id_agence'] ?>"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <?php include __DIR__ . '/../layouts/footer.php'; ?>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
