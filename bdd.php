<?php

// Connexion BDD
try{
    // Changez ici avec vos paramètres de connexion
    $bdd = new PDO('mysql:host=localhost;dbname=projet2;charset=utf8', 'root', '');
} catch(Exception $e){
    die('erreur: '.$e->getMessage());
}
// Affichage des erreurs SQL si il y en a
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);