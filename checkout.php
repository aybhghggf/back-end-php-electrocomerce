<?php
session_start();
require_once 'functions.php'; // Assume this file contains the database connection function and getProductById

// Initialize variables
$totalPrice = 0;
$totalItems = 0;
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}else{
    header('location:conexion.php?meg=cnx');
}
// Check if the cart is not empty
if (isset($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $id => $quantity) {
        $product = getProductById($id); // Get product details by ID
        if ($product) {
            $totalItems += $quantity;
            $totalPrice += $product['prix'] * $quantity;
        }
    }
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture the user details from the form
    $nom_complet = $_POST['nom_complet'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    // Insert each product from the cart into the "commande" table
    if (isset($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $id => $quantity) {
            $product = getProductById($id);
            if ($product) {
                // Prepare the SQL query to insert the order into the database
                $stmt = $pdo->prepare("INSERT INTO commande (nom_complet, adresse, telephone, produit_id, nom_produit, quantite, prix_unitaire, total_ligne) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                
                // Calculate total price for this product
                $totalProductPrice = $product['prix'] * $quantity;

                // Execute the query with the parameters
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

        // Clear the cart after inserting the order
        unset($_SESSION['panier']);

        // Redirect the user to a confirmation page (or order details page)
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

        <!-- Display Cart Items -->
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
                        $product = getProductById($id); // Fetch the product details by ID
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

        <!-- Order Form -->
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

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
