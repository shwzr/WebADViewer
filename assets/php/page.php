<?php
// Détermine la page actuelle à partir de la requête GET ou définit par défaut à 1 si non spécifié
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Appelle la fonction pour parser les résultats LDAP et stocke le tableau des groupes d'utilisateurs
$all_users_groups = parseLDAPResults($output);

// Calcule le nombre total de pages nécessaires, en divisant le nombre total d'utilisateurs par le nombre d'utilisateurs par page
$total_pages = ceil(count($all_users_groups) / $users_per_page);

// Calcule le point de départ pour la coupe des résultats en fonction de la page actuelle
$start = ($page - 1) * $users_per_page;

// Extrait la tranche d'utilisateurs à afficher sur la page courante
$display_users = array_slice($all_users_groups, $start, $users_per_page, true);
?>
