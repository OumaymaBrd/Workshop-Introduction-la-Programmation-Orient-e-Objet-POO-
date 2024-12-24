<?php

$host = 'localhost';
$dbname = 'cabinet_medical';
$username = 'root';       
$password = '';           

try {
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configuration des attributs PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->exec("SET NAMES utf8");
    
} catch(PDOException $e) {
    // En cas d'erreur, afficher le message
    die("Erreur de connexion : " . $e->getMessage());
}
?>

