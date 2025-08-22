<?php
// Vérification de l'accès admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?page=home');
    exit;
}

$agence = $agence ?? ['ville' => '']; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'agence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= \App\Config\Config::baseUrl() ?>/public/assets/css/main.css">

</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <?php include __DIR__ . '/../../layouts/header.php'; ?>

    <main class="container mt-5">

    <div class="d-flex flex-row align-items-center">
        <a class="iconBS" href="index.php?controller=admin&action=listAgences"><i class="bi bi-arrow-bar-left fs-2"></i></a>
        <h1 class="text-center p-3">Modifier l'agence</h1>
    </div>       

        <form method="POST">
            <div class="mb-3">
                <label for="ville" class="form-label">Ville</label>
                <input type="text" name="ville" id="ville" class="form-control" value="<?= htmlspecialchars($agence['ville']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="index.php?controller=admin&action=listAgences" class="btn btn-secondary">Annuler</a>
        </form>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../../layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
