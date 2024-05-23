<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_COOKIE[session_name()])) {
    header("Location: login.php");
    exit;
}

// Récupère le type de connexion depuis la session
$connection_type = isset($_SESSION["connection_type"]) ? $_SESSION["connection_type"] : "Inconnu";
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
            background-color: #005fa6;
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
        <li><a href="teams.php">Equipes</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Profil</h2>
    <div class="image-container">
        <img src="assets/img/user.png" alt="Image utilisateur" style="width: 80px; height: 80px; display: flex; margin: auto; margin-bottom: 50px; border: 3px solid #0077cc; border-radius: 50%; padding: 10px;">
    </div>
    <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8'); // Affiche le nom d'utilisateur en sécurité ?></p>
    <p><strong>Connexion :</strong> <?php echo "Connexion " . htmlspecialchars($connection_type, ENT_QUOTES, 'UTF-8') . " reussie."; // Affiche le type de connexion ?></p>
    <div style="text-align: center; margin-top: 20px;">
        <a href="logout.php" class="logout-link">Deconnexion</a>
    </div>
</div>

<footer>
    <p>&copy; 2024 WebADViewer</p>
</footer>

</body>
</html>
