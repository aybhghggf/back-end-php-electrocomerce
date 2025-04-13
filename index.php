<?php
session_start();
require_once 'db.php';
require_once 'functions.php';
if(isset($_GET['msg'])&& $_GET['msg']=='okk'){
    echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Connexion réussie !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
}
if (isset($_POST['min_price']) && isset($_POST['max_price']) && isset($_POST['categorie'])&& isset($_POST['sort_by'])) {
    $prixmin = $_POST['min_price'];
    $prixmax = $_POST['max_price'];
    $categoriefil = $_POST['categorie'];
    $order= $_POST['sort_by'];
} else {
    $prixmin = null;
    $prixmax = null;
    $categoriefil = null;
    $order =null;
}
$produits = getProduits($categoriefil, $prixmin, $prixmax,$order);
$categories = getCategories();
$totalitems=0;
if(isset($_SESSION['panier'])){
    $totalitems = array_sum($_SESSION['panier']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electrocommerce</title>
    <link rel="stylesheet" href="s.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">Electrocommerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
                    <li class="nav-item"><a href="panier.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Panier</a></li>
                    <span class="badge"><?php echo $totalitems; ?></span> <!-- Display item count -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> Compte
                        </a>
                        <?php 
                            if(isset($_SESSION['user'])){ ?>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="orders.php">Mes Commandes</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Déconnexion</a></li>
                        </ul>
                        <?php } else { ?> 
                            <ul class="dropdown-menu dropdown-menu-end"> 
                                <li><a class="dropdown-item" href="login.php">Connexion</a></li>
                                <li><a class="dropdown-item" href="register.php">Inscription</a></
                            </ul>
                            <?php } ?>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN -->
    <div class="container mt-5">
        <div class="row">
            <!-- FILTERS -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm p-3">
                    <h5 class="filter-title mb-3">Filtres</h5>
                    <form action="index.php" method="post">
                        <div class="mb-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <select class="form-select" id="categorie" name="categorie">
                                <option value="Toutes">Toutes</option>
                                <?php foreach ($categories as $categorie) { ?>
                                    <option value="<?= $categorie['id_categorie']; ?>" <?= (isset($categoriefil) && $categoriefil == $categorie['id_categorie']) ? 'selected' : ''; ?>>
                                        <?= $categorie['nom_categorie']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="min_price" class="form-label">Prix Min</label>
                            <input type="number" class="form-control" name="min_price" id="min_price" placeholder="0" value="<?= $min_price; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="max_price" class="form-label">Prix Max</label>
                            <input type="number" class="form-control" name="max_price" id="max_price" placeholder="5000" value="<?= $max_price; ?>">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary w-100">Appliquer</button>
                    </form>
                </div>
            </div>
                                 
            <!-- PRODUCTS -->
            <div class="col-md-9">
                <div class="row" id="products">
                    <?php foreach ($produits as $produit) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?= $produit['image_path']; ?>" class="card-img-top" alt="<?= $produit['nom']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $produit['nom']; ?></h5>
                                    <p class="card-text fw-bold text-primary"><?= $produit['prix']; ?> DH</p>
                                    <form action="ajouterpanier.php?id=<?php echo $produit['id_produit']; ?>" method="post">
                                        <button type="submit" class="btn btn-outline-success w-100" name="ajouter">Ajouter au panier</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
