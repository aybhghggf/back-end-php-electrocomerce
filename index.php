<?php 
require_once 'db.php';
require_once 'functions.php';
$produits= getProduits();
var_dump( $produits );
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- For Icons -->
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark  shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">E-commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="panier.php">
                            <i class="fas fa-shopping-cart"></i> Cart
                        </a>
                    </li>

                    <!-- Dropdown Menu for User Profile -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fas fa-user"></i> Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="orders.php">My Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
     <!-- Main Section -->
     <div class="container-fluid mt-4">
        <div class="row">
            <!-- Section Left: Filters -->
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm p-3">
                    <h5 class="mb-3">Filtrer</h5>
                    <form action="#" method="GET">
                        <!-- Catégories -->
                        <div class="mb-3">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <select class="form-select" id="categorie" name="categorie">
                                <option value="">Toutes</option>
                                <!-- TODO: Fill with PHP -->
                            </select>
                        </div>

                        <!-- Prix min -->
                        <div class="mb-3">
                            <label for="min_price" class="form-label">Prix Min</label>
                            <input type="number" class="form-control" id="min_price" name="min_price" placeholder="0">
                        </div>

                        <!-- Prix max -->
                        <div class="mb-3">
                            <label for="max_price" class="form-label">Prix Max</label>
                            <input type="number" class="form-control" id="max_price" name="max_price" placeholder="5000">
                        </div>

                        <!-- Bouton filtre -->
                        <button type="submit" class="btn btn-primary w-100">Appliquer</button>
                    </form>
                </div>
            </div>

            <!-- Section Right: Products -->
            <div class="col-md-9">
                <div class="row" id="products"> 
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Nom Produit</h5>
                                <p class="card-text">Prix: 200 DH</p>
                                <a href="#" class="btn btn-sm btn-outline-primary">Ajouter au panier</a>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
