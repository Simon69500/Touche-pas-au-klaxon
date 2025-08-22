<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= \App\Config\Config::baseUrl() ?>/public/assets/css/main.css">    
    <title>Liste des utilisateurs</title>
</head>
<body>
        <!-- Header -->
    <?php include __DIR__ . '/../../layouts/header.php'; ?>


    <main class="container mt-4">

            <div class="d-flex flex-row align-items-center">
                <a class="iconBS" href="index.php?controller=admin&action=dashboard"><i class="bi bi-arrow-bar-left fs-2"></i></a>
                <h1 class="text-center p-3">Liste des utilisateurs</h1>
            </div>        

        <!-- Utilisateurs -->
            <div class="tab-pane fade show active" id="users">
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
                        <?php $users = $users ?? []; ?>
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
    </main>

        <!-- Footer -->
    <?php include __DIR__ . '/../../layouts/footer.php'; ?>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>