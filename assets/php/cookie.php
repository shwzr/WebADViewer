<?php
// Vérifie si la requête est de type POST, ce qui signifie que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si l'utilisateur accepte les cookies
    if (isset($_POST['accept_cookies'])) {
        // Crée un cookie 'accept_cookies' qui expire après 24 heures
        setcookie('accept_cookies', 'true', time() + 24 * 60 * 60, '/', '', true, true);
        // Enregistre dans la session que les cookies n'ont pas été refusés
        $_SESSION['cookie_declined'] = false;
    }
    // Si l'utilisateur refuse les cookies
    if (isset($_POST['decline_cookies'])) {
        // Supprime le cookie 'accept_cookies' en définissant une date d'expiration dans le passé
        setcookie('accept_cookies', '', time() - 3600, '/'); 
        // Enregistre dans la session que les cookies ont été refusés
        $_SESSION['cookie_declined'] = true;
    }
}

// Vérifie si le cookie 'accept_cookies' est défini et assigne la valeur à la variable $cookieSet
$cookieSet = isset($_COOKIE['accept_cookies']);
// Vérifie si le consentement aux cookies a été refusé et assigne le résultat à la variable $declinedCookies
$declinedCookies = isset($_SESSION['cookie_declined']) && $_SESSION['cookie_declined'];
?>
