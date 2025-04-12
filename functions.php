<?php
require_once 'db.php';
function getProduits()
{
    global $pdo;

    // Récupérer tous les produits sans filtre
    $req = "SELECT * FROM produit";
    $stmt = $pdo->prepare($req);
    $stmt->execute();

    // Récupérer tous les produits
    $produits = $stmt->fetchAll();
    return $produits;
}
function getCategories()
{
    global $pdo;

    // Récupérer toutes les catégories sans filtre
    $req = "SELECT * FROM categorie";
    $stmt = $pdo->prepare($req);
    $stmt->execute();

    // Récupérer toutes les catégories
    $categories = $stmt->fetchAll();
    return $categories;
}

?>
