<?php
/**
 * Header template
 * 
 * Affiche le nom de l’application et les boutons selon l’état de connexion de l’utilisateur
 * - Utilisateur non connecté : bouton Connexion
 * - Utilisateur connecté : bouton création trajet, nom, déconnexion
 * - Administrateur : liens vers sections admin + déconnexion
 * 
 * @author Simon
 * @version 1.0
 */


    $user = $_SESSION['user'] ?? null;
?>

<header class="bg-light p-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="?page=home"><h3>Touche pas au klaxon</h3></a>

        <?php $baseUrl = \App\Config\Config::baseUrl(); ?>
        <nav>
            <?php if (!$user): ?>
                <!-- Utilisateur non connecté -->
                <a href="<?= $baseUrl ?>?page=login" class="btn btn-primary">Connexion</a>

            <?php elseif ($user['role'] === 'admin'): ?>
                <!-- Administrateur -->
                <a href="index.php?controller=admin&action=listUsers" class="btn btn-info">Utilisateurs</a>
                <a href="index.php?controller=admin&action=listAgences" class="btn btn-info">Agences</a>
                <a href="index.php?controller=admin&action=listTrips" class="btn btn-info">Trajets</a>
                <span class="ms-2">Bonjour <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></span>
                <a href="<?= $baseUrl ?>?page=logout" class="btn btn-danger ms-2">Déconnexion</a>

            <?php else: ?>
                <!-- Utilisateur connecté -->
                <a href="<?= $baseUrl ?>?page=create" class="btn btn-success">Créer un trajet</a>
                <span class="ms-2">Bonjour <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></span>
                <a href="<?= $baseUrl ?>?page=logout" class="btn btn-danger ms-2">Déconnexion</a>
            <?php endif; ?>
        </nav>
    </div>
</header>