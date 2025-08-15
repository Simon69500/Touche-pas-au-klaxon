<?php

// Générer le hash pour le mot de passe pour les tests
$password = 'password123';
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

echo $passwordHash;
