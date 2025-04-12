<?php
require_once 'db.php';
function getProduits($categoriefil = null, $prixmin = null, $prixmax = null)
{
    global $pdo;
    $req = "SELECT * FROM produit WHERE 1=1";
    $params = [];
    $conditions = [];

    if ($categoriefil !== null && $categoriefil !== "Toutes") {
        $conditions[] = "categorie_id = :category";
        $params[':category'] = $categoriefil;
    }
    if (!empty($prixmin) && !empty($prixmax)) {
        $conditions[] = "prix BETWEEN :prixmin AND :prixmax";
        $params[':prixmin'] = $prixmin;
        $params[':prixmax'] = $prixmax;
    } elseif (!empty($prixmin)) {
        $conditions[] = "prix >= :prixmin";
        $params[':prixmin'] = $prixmin;
    } elseif (!empty($prixmax)) {
        $conditions[] = "prix <= :prixmax";
        $params[':prixmax'] = $prixmax;
    }

    if (!empty($conditions)) {
        $req .= " AND " . implode(" AND ", $conditions);
    }
    $stmt = $pdo->prepare($req);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function getCategories()
{
    global $pdo;

    $req = "SELECT * FROM categorie";
    $stmt = $pdo->prepare($req);
    $stmt->execute();

    $categories = $stmt->fetchAll();
    return $categories;
}
?>
