<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/index.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <title>Accueil - Touche pas au klaxon</title>
</head>
<body>

    <?php include 'header.php'; ?>

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
                    <td><?= htmlspecialchars($trip['ville_depart']) ?></td>
                    <td><?= date('Y-m-d', strtotime($trip['date_heure_depart'])) ?></td>
                    <td><?= date('H:i', strtotime($trip['date_heure_depart'])) ?></td>
                    <td><?= htmlspecialchars($trip['ville_arrivee']) ?></td>
                    <td><?= date('Y-m-d', strtotime($trip['date_heure_arrive'])) ?></td>
                    <td><?= date('H:i', strtotime($trip['date_heure_arrive'])) ?></td>
                    <td><?= htmlspecialchars($trip['places_dispo']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>                                                    
     </main>

    <?php include 'footer.php'; ?>
</body>
</html>