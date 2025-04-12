<?php 
if(!isset($_SESSION)){
    session_start();
}

if(isset($_GET['id'])){
    $id =$_GET['id']; 
}

if(!isset($_SESSION['panier'])){
    $_SESSION['panier'] =[];
}

if(!isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id] = 1;
    $_SESSION['message'] = 'vous avez ajouté un produit au panier';
    header('Location:index.php');
}else{
    $_SESSION['panier'][$id] += 1;
    $_SESSION['message'] = ' vous avez ajoutez la quantité avec succes';
    header('Location:index.php');
}
?>
