<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/index.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <title>Accueil - Touche pas au klaxon</title>
</head>
<body>

    <?php include __DIR__. '/../layouts/header.php'; ?>

    <!-- Contenue principal -->
     <main class="container mt-5">
        <h1>Liste des trajets </h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Départ</th>
                    <th scope="col">Date départ</th>
                    <th scope="col">Heure départ</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Date arrivée</th>
                    <th scope="col">Heure arrivée</th>
                    <th scope="col">Places dispo</th>
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

                    <!-- Actions -->
                    <td>
                        <?php if(isset($_SESSION['user'])): ?>
                            <!-- Icône pour ouvrir le modal -->
                            <a href="#" data-bs-toggle="modal" data-bs-target="#trajetModal<?= $trip['id_trajet'] ?>"><i class="bi bi-eye"></i></a>
                            
                            <!-- Si l’utilisateur est l’auteur, il peut aussi modifier/supprimer -->
                            <?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] == $trip['auteur_id']): ?>
                            <a href="/trips/edit?id=<?= $trip['id_trajet'] ?>"><i class="bi bi-pencil-square"></i></a>
                            <a href="/trips/delete?id=<?= $trip['id_trajet'] ?>"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <!-- Modal -->
                <?php include __DIR__. '/../layouts/modal.php'; ?>

                <?php endforeach; ?>
            </tbody>
        </table>                                                    
     </main>

    <?php include __DIR__. '/../layouts/footer.php'; ?>
</body>
</html>