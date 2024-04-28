<?php
session_start(); // Démarre la gestion de session

// Vérifie si l'utilisateur est connecté et définit les variables pour l'affichage des liens
$show_profile_link = false;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $show_profile_link = true;
    $show_teams_link = true;
}

require 'assets/php/cookie.php'; // Intègre le gestionnaire de cookies
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebADViewer</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>

<header>
    <h1>WebADViewer</h1>
</header>

<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <?php if ($show_profile_link): ?>
            <li><a href="logged.php">Profil</a></li>
        <?php endif; ?>
        <?php if ($show_teams_link): ?>
            <li><a href="teams.php">Équipes</a></li>
        <?php endif; ?>
        <?php if (!$show_profile_link && !$declinedCookies): ?>
            <li id="loginLink"><a href="login.php">Connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div class="content">
    <h2>À propos de WebADViewer</h2>
    <p>WebADViewer est une application web conçue pour permettre aux utilisateurs de se connecter à un Active Directory via LDAP et de visualiser les informations sur les utilisateurs et les groupes de manière sécurisée et efficace.</p>
</div>

<div class="content">
    <h2>Objectifs</h2>
    <p>WebADViewer offre aux employés d'une entreprise un moyen simple de trouver des informations sur leurs collègues via l'Active Directory, tout en fournissant un outil pratique pour tester la connectivité et la validité des accès utilisateur au sein de l'AD.</p>
</div>

<footer>
    <p>&copy; 2024 WebADViewer</p>
</footer>

<?php if (!$cookieSet && !$declinedCookies && !$show_profile_link): ?>
<div id="cookieConsentContainer" class="cookie-alert">
    <strong>🍪 Cookies</strong>
    <p>Acceptez-vous l'utilisation de cookies?</p>
    <button onclick="acceptCookies()" class="cookie-button accept">Oui</button>
    <button onclick="declineCookies()" class="cookie-button decline">Non</button>
</div>
<script>
function acceptCookies() {
    document.getElementById('cookieConsentContainer').style.bottom = "-100px";
    document.cookie = "accept_cookies=true; path=/; max-age=" + 60 * 60 * 24 * 365;
}

function declineCookies() {
    var container = document.getElementById('cookieConsentContainer');
    container.style.bottom = "-100px";
    setTimeout(function() { container.style.display = "none"; }, 500);
    document.getElementById('loginLink').style.display = 'none';
    document.cookie = 'accept_cookies=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
}
</script>
<?php endif; ?>

</body>
</html>
