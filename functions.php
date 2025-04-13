<?php
require_once 'db.php';
function getsession(){
    if(!isset($_SESSION)){
        session_start();
    }
}
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
function getProductById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}
function addClient($nomcomplet=null ,$email=null ,$password=null){
    global $pdo;
    if( !empty($nomcomplet) && !empty($email) && !empty($password)){
        $req="INSERT INTO `client`( `nom_complet`, `email`, `password`) VALUES (?,?,?)";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$nomcomplet,$email,$password]);

    }}
function getclient($email =null ,$password=null,$client= null){
    global $pdo;
    if( !empty($email) && !empty($password)){
        $req="SELECT * FROM `client` WHERE `email`= ? AND `password`= ? ";
        $stmt = $pdo->prepare($req);
        $stmt->execute([$email,$password]);
        $client= $stmt->fetch();
        return $client;
    }
}
?>
