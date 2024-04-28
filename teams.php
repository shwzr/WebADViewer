<?php
session_start();
// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Inclusion des fichiers nécessaires pour le fonctionnement de la page
require 'assets/php/allusers.php';
require 'assets/php/page.php';

// Récupérer et afficher les utilisateurs
$users = parseLDAPResults($_SESSION["ldap_output"]);
$total_pages = ceil(count($users) / $users_per_page);
$display_users = array_slice($users, ($page - 1) * $users_per_page, $users_per_page);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <title>WebADViewer - Équipes</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>

<header>
    <h1>WebADViewer</h1>
</header>

<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="logged.php">Profil</a></li>
        <li><a href="teams.php" class="active">Équipes</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Équipes</h2>
<table style="width: 100%; margin: 0 auto; border-collapse: collapse; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <tr>
            <th style="padding: 12px 15px; border: 1px solid #007bff; background-color: #007bff; color: white;">Nom d'utilisateur</th>
            <th style="padding: 12px 15px; border: 1px solid #007bff; background-color: #007bff; color: white;">Services</th>
        </tr>
        <?php foreach ($display_users as $user => $info): ?>
            <tr style="background-color: #ffffff; border-bottom: 1px solid #ccc;">
                <td style="padding: 10px 15px; text-align: left;"><?= htmlspecialchars($info['username']); ?></td>
                <td style="padding: 10px 15px; text-align: left;"><?= htmlspecialchars(implode(", ", $info['services'])); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="pagination">
        <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1; ?>">&laquo; Précédent</a>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1; ?>">Suivant &raquo;</a>
        <?php endif; ?>
    </div>
</div>

<footer>
    <p>&copy; 2024 WebADViewer</p>
</footer>

</body>
</html>
