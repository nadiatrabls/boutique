<?php
require '../vendor/autoload.php';



use Boutique\Controllers\AccueilController;
use Boutique\Controllers\ProduitsController;

$url=($_GET['url'])??null;

if($url==='produits'){
    (new ProduitsController)->index();

}
else{
    (new AccueilController)->index();

}