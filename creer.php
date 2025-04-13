<?php 
require_once 'functions.php';
session_start();
if(isset($_GET['msg'])&& $_GET['msg']=="Creer"){
    echo "<script>alert('Vous devez creer un compte pour vous commander')</script>";
}
if(isset($_POST['nom_complet'])&& isset($_POST['email'])&&isset($_POST['password'])){
    $nom_complet = $_POST['nom_complet'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    addClient( $nom_complet, $email, $password );
    header('location:conexion.php?msg=okc');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Créer un compte</h2>
    <form action="creer.php" method="POST">
        <div class="mb-3">
            <label for="nom_complet" class="form-label">Nom Complet</label>
            <input type="text" class="form-control" id="nom_complet" name="nom_complet" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de Passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit" class="btn btn-primary">Créer le compte</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
