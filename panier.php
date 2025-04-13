<?php
session_start();
require_once 'functions.php';

// إعداد المتغيرات
$totalItems = 0;
$totalPrice = 0;

// نتحقق واش كاين شي منتوج فـ البانيير
if (isset($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $id => $quantity) {
        $product = getProductById($id);
        if ($product) {
            $totalItems = $totalItems + $quantity;
            $totalPrice = $totalPrice + ($product['prix'] * $quantity);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php">Electrocommerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Accueil</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link">Connexion</a></li>
                <li class="nav-item"><a href="register.php" class="nav-link">Inscription</a></li>
                <li class="nav-item">
                    <a href="panier.php" class="nav-link">
                        <i class="fas fa-shopping-cart"></i> Panier
                        <span class="badge bg-secondary"><?php echo $totalItems; ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h2>Votre Panier</h2>

    <?php
    if ($totalItems > 0) {
        echo '<table class="table table-striped table-bordered">';
        echo '<thead>
                <tr>
                    <th>Nom du produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
              </thead>';
        echo '<tbody>';
        foreach ($_SESSION['panier'] as $id => $quantity) {
            $product = getProductById($id);
            if ($product) {
                $totalProductPrice = $product['prix'] * $quantity;
                echo '<tr>';
                echo '<td>' . $product['nom'] . '</td>';
                echo '<td>' . $quantity . '</td>';
                echo '<td>' . $product['prix'] . ' MAD</td>';
                echo '<td>' . $totalProductPrice . ' MAD</td>';
                echo '</tr>';
            }
        }
        echo '</tbody>';
        echo '</table>';

        echo '<div class="mt-3">';
        echo '<h4>Total Panier: ' . $totalPrice . ' MAD</h4>';
        echo '<a href="checkout.php" class="btn btn-primary">Passer à la caisse</a>';
        echo '</div>';
    } else {
        echo '<p>Votre panier est vide.</p>';
    }
    ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
