<?php
session_start(); // Démarre ou reprend une session utilisateur

require 'config.php'; // Inclut la configuration LDAP pour l'authentification

// Vérifie si l'utilisateur est déjà connecté pour conditionnellement afficher le lien de profil
$show_profile_link = false;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $show_profile_link = true;
}

require 'assets/php/request.php'; // Intègre les fonctionnalités pour le traitement des requêtes
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebADViewer - Connexion</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css"> <!-- Lien vers la feuille de style CSS -->
</head>
<body>

<header>
    <h1>WebADViewer</h1>
</header>

<nav>
    <ul>
        <?php if ($show_profile_link): // Affiche le lien vers le profil si l'utilisateur est connecté ?>
            <li><a href="profile.php">Mon Profil</a></li>
        <?php endif; ?>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="login.php">Connexion</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Connexion</h2>
    <p>Veuillez remplir vos identifiants pour vous connecter.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Se connecter">
        
        <!-- Affiche un message d'erreur si échec de la connexion -->
        <p class="error"><?php echo isset($login_err) ? $login_err : ''; ?></p>
    </form>
</div>

<footer>
    <p>&copy; 2024 WebADViewer</p>
</footer>

</body>
</html>
