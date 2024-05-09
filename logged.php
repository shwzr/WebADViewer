<?php
session_start(); // Démarre ou reprend une session
require 'assets/php/request.php'; // Inclut le fichier de requête pour des opérations supplémentaires

// Redirige l'utilisateur vers la page de connexion si non connecté ou si la session/cookie est invalide
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_COOKIE[session_name()])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebADViewer - Profil</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <style>
        .logout-link:hover {
            background-color: #005fa6; /* Modifie le fond au survol pour le lien de déconnexion */
        }
    </style>
</head>
<body>

<header>
    <h1>WebADViewer</h1>
</header>

<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="logged.php">Profil</a></li>
        <li><a href="teams.php">Équipes</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Profil</h2>
    <div class="image-container">
        <img src="assets/img/user.png" alt="Image utilisateur" style="width: 80px; height: 80px; display: flex; margin: auto; margin-bottom: 50px; border: 3px solid #0077cc; border-radius: 50%; padding: 10px;">
    </div>
    <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($_SESSION["username"]); // Affiche le nom d'utilisateur en sécurité ?></p>
    <div style="text-align: center; margin-top: 20px;">
        <a href="logout.php" class="logout-link">Déconnexion</a> <!-- Lien de déconnexion -->
    </div>
</div>

<footer>
    <p>&copy; 2024 WebADViewer</p>
</footer>

</body>
</html>
