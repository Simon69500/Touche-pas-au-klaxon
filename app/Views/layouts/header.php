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

<header>
    <h3>
        Touche pas au klaxon
    </h3>

    <nav>
        <?php if (!$user): ?>
        <!-- Utilisateur non connecté -->
         <button onclick="location.href='/login'">Connexion</button>

        <?php elseif ($user['role'] === 'admin'): ?>
         <!-- Administrateur -->
         <button onclick="location.href=''"></button>
         <button onclick="location.href=''"></button>  
         <button onclick="location.href=''"></button>     
         <span>Bonjour <?=htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></span>
         <button onclick="location.href=''">Déconnexion</button>

         <?php else: ?>
        <!-- Utilisateur connecté -->
         <button onclick="location.href=''">Créer un trajet</button>
         <span>Bonjour <?=htmlspecialchars($user['prenom'] . '' . $user['nom']) ?></span>
         <button onclick="location.href=''">Déconnexion</button>
         
         <?php endif; ?>
    </nav>
</header>