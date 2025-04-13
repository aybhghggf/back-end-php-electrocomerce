<?php
session_start();
require_once 'functions.php';

$totalPrice = 0;
$totalItems = 0;
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}else{
    header('location:conexion.php?meg=cnx');
}

if (isset($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $id => $quantity) {
        $product = getProductById($id);
        if ($product) {
            $totalItems += $quantity;
            $totalPrice += $product['prix'] * $quantity;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_complet = $_POST['nom_complet'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    if (isset($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $id => $quantity) {
            $product = getProductById($id);
            if ($product) {
                $stmt = $pdo->prepare("INSERT INTO commande (nom_complet, adresse, telephone, produit_id, nom_produit, quantite, prix_unitaire, total_ligne) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                
                $totalProductPrice = $product['prix'] * $quantity;

                $stmt->execute([
                    $nom_complet,
                    $adresse,
                    $telephone,
                    $id,
                    $product['nom'],
                    $quantity,
                    $product['prix'],
                    $totalProductPrice
                ]);
            }
        }

        unset($_SESSION['panier']);
        header("Location:index.php?mesage=bienpasser");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Passer à la caisse</h2>

        <h4>Articles dans le Panier</h4>
        <?php if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['panier'] as $id => $quantity) {
                        $product = getProductById($id);
                        if ($product) {
                            $totalProductPrice = $product['prix'] * $quantity;
                            echo "<tr>
                                    <td>{$product['nom']}</td>
                                    <td>{$quantity}</td>
                                    <td>{$product['prix']} MAD</td>
                                    <td>{$totalProductPrice} MAD</td>
                                  </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

            <div class="mt-3">
                <h4>Total Panier: <?php echo $totalPrice; ?> MAD</h4>
            </div>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>

        <form method="POST" action="checkout.php">
            <div class="mb-3">
                <label for="nom_complet" class="form-label">Nom Complet</label>
                <input type="text" class="form-control" id="nom_complet" name="nom_complet" placeholder="<?php if($user){echo $user ;}?>" required>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Numéro de téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" required>
            </div>

            <button type="submit" class="btn btn-primary">Valider la commande</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
