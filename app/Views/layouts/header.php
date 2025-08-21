<?php
/**
 * Header template
 *
 * Affiche le nom de l’application et les boutons selon l’état de connexion de l’utilisateur
 *
 * @author Simon
 * @version 1.1
 */

/** 
 * @var array{role?: string, prenom?: string, nom?: string}|null $user
 */
$user = $_SESSION['user'] ?? null;

$baseUrl = \App\Config\Config::baseUrl();
?>

<header class="bg-light p-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h3>Touche pas au klaxon</h3>

        <nav>
            <?php if ($user === null): ?>
                <!-- Utilisateur non connecté -->
                <a href="<?= $baseUrl ?>?page=login" class="btn btn-primary">Connexion</a>

            <?php elseif (($user['role'] ?? '') === 'admin'): ?>
                <!-- Administrateur -->
                <a href="index.php?controller=admin&action=listUsers" class="btn btn-info">Utilisateurs</a>
                <a href="index.php?controller=admin&action=listAgences" class="btn btn-info">Agences</a>
                <a href="index.php?controller=admin&action=listTrips" class="btn btn-info">Trajets</a>
                <span class="ms-2">Bonjour <?= htmlspecialchars($user['prenom'] ?? '') . ' ' . htmlspecialchars($user['nom'] ?? '') ?></span>
                <a href="<?= $baseUrl ?>?page=logout" class="btn btn-danger ms-2">Déconnexion</a>

            <?php else: ?>
                <!-- Utilisateur connecté -->
                <a href="<?= $baseUrl ?>?page=create" class="btn btn-success">Créer un trajet</a>
                <span class="ms-2">Bonjour <?= htmlspecialchars($user['prenom'] ?? '') . ' ' . htmlspecialchars($user['nom'] ?? '') ?></span>
                <a href="<?= $baseUrl ?>?page=logout" class="btn btn-danger ms-2">Déconnexion</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
