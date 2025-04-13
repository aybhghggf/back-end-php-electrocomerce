<?php 
require_once 'functions.php';
getsession();
$categories = getCategories();
$totalitems=0;
if(isset($_SESSION['panier'])){
    $totalitems = array_sum($_SESSION['panier']);
}
if (!isset($_SESSION['user'])) {
    header('Location: conexion.php?meg=cnx');
    exit;
}

$user = $_SESSION['user'];

$stmt = $pdo->prepare("SELECT * FROM commande WHERE nom_complet = ?");
$stmt->execute([$user]);
$orders = $stmt->fetchAll()
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
                    <span class="badge"><?php echo $totalitems; ?></span>
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
                                <li><a class="dropdown-item" href="conexion.php">Connexion</a></li>
                                <li><a class="dropdown-item" href="creer.php">Inscription</a></li>
                            </ul>
                            <?php } ?>

                    </li>
                </ul>
            </div>
        </div>
    </nav>   
    <div class="container mt-5">
        <h2>Mes Commandes</h2>

        <?php if (count($orders) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        
                        <th>ID Commande</th>
                        <th>Nom du Produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                        <th>Date de Commande</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['nom_produit']; ?></td>
                            <td><?php echo $order['quantite']; ?></td>
                            <td><?php echo $order['prix_unitaire']; ?> MAD</td>
                            <td><?php echo $order['total_ligne']; ?> MAD</td>
                            <td><?php echo $order['date_commande']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune commande trouvée.</p>
        <?php endif; ?>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
</body>
</html>