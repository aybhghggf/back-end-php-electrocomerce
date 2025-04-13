<?php 
require_once 'functions.php';
getsession();
if(!isset($_SESSION['user'])){
    header('Location:creer.php?msg=Creer');
    exit();
}

?>