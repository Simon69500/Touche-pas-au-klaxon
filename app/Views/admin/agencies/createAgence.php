<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une agence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include __DIR__ . '/../../layouts/header.php'; ?>

<main class="container mt-4">
    <h1>Ajouter une agence</h1>

    <form method="POST">
        <div class="mb-3">
            <label for="ville" class="form-label">Nom de la ville</label>
            <input type="text" class="form-control" name="ville" id="ville" required>
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
        <a href="index.php?controller=admin&action=listAgences" class="btn btn-secondary">Annuler</a>
    </form>
</main>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
