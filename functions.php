<?php 
require_once 'db.php';

function getProduits(){
    global $pdo ;
    $req=" SELECT * FROM produit";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $produits = $stmt->fetchAll();
    return $produits;
}



?>