<?php
// Démarre la session
session_start();

// Efface toutes les variables de session
$_SESSION = array();

// Vérifie si le cookie de session a été utilisé
if (isset($_COOKIE[session_name()])) {
    // Efface le cookie de session en définissant sa date d'expiration dans le passé
    setcookie(session_name(), '', time() - 42000, '/');
}

// Détruit la session
session_destroy();

// Redirige l'utilisateur vers la page de connexion
header("location: login.php");
exit;
?>
