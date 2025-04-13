<?php 
require_once 'functions.php';
getsession();
if(isset($_GET['meg']) && $_GET['meg'] == 'cnx'){
    echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
    vous devez connecter a un compte pour vous efeectuez
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
}
if(isset($_GET['msg'])&& $_GET['msg']=="okc"){
    echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ Creation de compte réussie !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
}
if(isset($_POST['email'])&&isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $client= getclient( $email, $password );
    if($client['email']== $email&&$client['password']==$password){
        $_SESSION['user']= $client['nom_complet'];
        header('Location:index.php?mg=okk');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 ">
    <h2 class="mb-4">Connexion</h2>
    <form action="conexion.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de Passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    <div class="mt-3">
        <p>Vous n'avez pas de compte ? <a href="creer.php">Créer un compte</a></p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
