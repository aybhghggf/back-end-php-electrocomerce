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
function getCategories(){
    global $pdo ;
    $req=" SELECT * FROM categorie";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $categories= $stmt->fetchAll();
    return $categories;
}



?>