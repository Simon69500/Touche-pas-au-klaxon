<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= \App\Config\Config::baseUrl() ?>/public/assets/css/main.css">

    <title>Liste des agences</title>
</head>
<body class="d-flex flex-column min-vh-100">
        <!-- Header -->
    <?php include __DIR__ . '/../../layouts/header.php'; ?>

<main class="container mt-4">
<?php $agences = $agences ?? []; ?>

    <div class="d-flex flex-row align-items-center">
        <a class="iconBS" href="index.php?controller=admin&action=dashboard"><i class="bi bi-arrow-bar-left fs-2"></i></a>
        <h1 class="text-center p-3">Liste des agences</h1>
    </div>      

    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash_message']['type']) ?> mt-3" role="alert">
            <?= htmlspecialchars($_SESSION['flash_message']['message']) ?>
        </div>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>

    <!-- Tableau -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom de la ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($agences) && is_array($agences)): ?>
                <?php foreach($agences as $agence): ?>
                    <tr>
                        <td><?= htmlspecialchars($agence['ville']) ?></td>
                        <td>
                            <a href="index.php?controller=admin&action=editAgence&id=<?= $agence['id_agence'] ?>"><i class="bi bi-pencil-square"></i></a>
                            <a href="index.php?controller=admin&action=deleteAgence&id=<?= $agence['id_agence'] ?>" 
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?');">
                            <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2">Aucune agence trouvée</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Bouton pour créer une nouvelle agence -->
    <a href="index.php?controller=admin&action=createAgence" class="btn btn-success mb-3">Ajouter une agence</a>
</main>

        <!-- Footer -->
    <?php include __DIR__ . '/../../layouts/footer.php'; ?>

        <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>