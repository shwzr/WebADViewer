<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les informations du formulaire
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    require 'config.php';

    // Tente d'abord avec LDAPS
    $ldap_command = "ldapsearch -x -H ldaps://{$ldap_host}:636 -D \"{$username}@{$ldap_domain}\" -w \"{$password}\" -b \"{$dc_string}\" \"(objectClass=user)\" sAMAccountName cn mail memberOf userPrincipalName";
    exec($ldap_command, $output, $return_value);

    // Si LDAPS échoue, réessayer immédiatement avec LDAP
    if ($return_value !== 0) {
        $ldap_command = "ldapsearch -x -H ldap://{$ldap_host}:{$ldap_port} -D \"{$username}@{$ldap_domain}\" -w \"{$password}\" -b \"{$dc_string}\" \"(objectClass=user)\" sAMAccountName cn mail memberOf userPrincipalName";
        exec($ldap_command, $output, $return_value);
    }

    // Traitement après la tentative de connexion
    if ($return_value === 0) {
        session_start();
        session_regenerate_id();  // Sécurise la session en régénérant l'ID

        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["groups"] = getGroupsFromLDAP($output, $username);
        $_SESSION["ldap_output"] = $output; // Stocke la sortie LDAP dans la session

        // Redirection vers la page de profil
        header("Location: logged.php");
        exit;
    } else {
        // Échec de l'authentification LDAP
        $login_err = "Identifiants incorrects.";
        // Assurez-vous que les erreurs sont gérées et affichées correctement
    }
}

function getGroupsFromLDAP($output, $username) {
    $groups = [];
    $capture = false;
    foreach ($output as $line) {
        if (strpos($line, "dn: CN=$username,") !== false) {
            $capture = true;
        }
        if ($capture && strpos($line, 'memberOf:') !== false) {
            preg_match('/CN=(.*?),/', $line, $matches);
            if (isset($matches[1])) {
                // Remplace "Administrators" par "Administrateurs"
                $group = $matches[1];
                if ($group === "Administrators") {
                    $group = "Administrateurs";
                }
                $groups[] = $group;
            }
        }
        if ($capture && strpos($line, 'dn:') !== false && strpos($line, "dn: CN=$username,") === false) {
            // Dès qu'on trouve une nouvelle DN qui n'est pas celle de l'utilisateur actuel, on arrête de capturer
            break;
        }
    }
    // Vérifie si l'utilisateur n'a aucun groupe assigné et assigne "x" si c'est le cas
    if (empty($groups)) {
        $groups[] = 'x';
    }
    return array_unique($groups);
}
?>
