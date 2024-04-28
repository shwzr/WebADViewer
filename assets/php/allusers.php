<?php
// Vérifie si la sortie LDAP est disponible en session, redirige sinon vers le script de requête
if (!isset($_SESSION["ldap_output"])) {
    header("Location: assets/php/request.php");
    exit;
}

$output = $_SESSION["ldap_output"]; // Récupère les données LDAP stockées en session
$users_per_page = 5; // Définit le nombre d'utilisateurs à afficher par page

// Fonction pour extraire les unités organisationnelles (OU) d'un DN
function extractOUs($dn) {
    $ous = [];
    if (preg_match_all('/OU=([^,]+)/', $dn, $matches)) {
        array_pop($matches[1]); // Supprime le dernier élément du tableau qui ne correspond pas à un OU pertinent
        $ous = $matches[1];
    }
    return $ous;
}

// Fonction pour analyser les résultats LDAP et structurer les données utilisateur
function parseLDAPResults($output) {
    $users = [];
    $current_user = null;

    // Parcourt chaque ligne de sortie LDAP
    foreach ($output as $line) {
        if (preg_match('/^dn:\s+CN=([^,]+),/', $line, $matches)) { // Vérifie si la ligne correspond à un nouveau DN d'utilisateur
            $current_user = $matches[1]; // Stocke le nom courant de l'utilisateur
            $ous = extractOUs($line); // Extrait les OUs de la ligne DN
            // Initialise les données de l'utilisateur dans le tableau
            $users[$current_user] = ['services' => $ous, 'username' => $current_user, 'userPrincipalName' => false];
        }
        // Définit si l'utilisateur a un userPrincipalName
        if ($current_user && preg_match('/^userPrincipalName:/', $line)) {
            $users[$current_user]['userPrincipalName'] = true;
        }
    }

    // Filtre les utilisateurs qui n'ont pas de userPrincipalName défini
    foreach ($users as $user => $info) {
        if (!$info['userPrincipalName']) {
            unset($users[$user]);
        }
    }

    return $users;
}
?>
