<?php
// Paramètres Freehostia mis à jour
$host = "localhost"; 
$dbname = "evrkra_votants_db"; // Freehostia préfixe souvent le nom avec ton pseudo
$user = "evrkra"; 
$pass = "evrard"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "Erreur de connexion : " . $e->getMessage()]));
}
?>