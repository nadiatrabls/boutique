<?php

require '../vendor/autoload.php';

use Boutique\Controllers\AccueilController;
use Boutique\Controllers\ProduitsController;
use Boutique\Controllers\UserController;
use Boutique\Controllers\CartController;
use Boutique\Controllers\OrderController;
use Boutique\Controllers\BlogController;
use Boutique\Controllers\ContactController;
use Boutique\Controllers\SingleProductController;
use Boutique\Controllers\CategorieController;

// Démarrage de la session pour gérer le panier et les favoris
session_start();

// Récupération de l'URL et de l'ID
$url = $_GET['url'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Routes pour les produits
if ($url === 'produits') {
    $ctrl = new ProduitsController;
    $ctrl->index(); // Affichage de tous les produits
    exit;
} elseif ($url === 'categorie') {
    $ctrl = new CategorieController;
    $ctrl->afficherProduitsParCategorie($id);
    exit;
} elseif ($url === 'sous-categorie') {
    $ctrl = new ProduitsController;
    $ctrl->produitsParSousCategorie($id);
    exit;
} elseif ($url === 'single-product') {
    $ctrl = new SingleProductController;
    $ctrl->details($id); // Affichage des détails du produit
    exit;
}

// Routes pour l'utilisateur
elseif ($url === 'login') {
    $ctrl = new UserController;
    $ctrl->index();
    exit;
}

// Routes pour le panier
 elseif ($url == 'ajouter-au-panier') {
    $ctrl = new CartController;
    $ctrl->ajouterAuPanier(); // Appel à la méthode d'ajout au panier
    exit;
}


// Routes pour les favoris
 elseif ($url == 'ajouter-aux-favoris') {
    $ctrl = new ProduitsController;
    $ctrl->ajouterAuxFavoris();
    exit;
}


// Routes pour la commande
elseif ($url === 'checkout' || $url === 'confirmation' || $url === 'tracking') {
    $ctrl = new OrderController;
    $ctrl->index();
    exit;
}

// Routes pour le blog
elseif ($url === 'blog' || $url === 'single-blog') {
    $ctrl = new BlogController;
    $ctrl->index();
    exit;
}

// Routes pour la page de contact
elseif ($url === 'contact') {
    $ctrl = new ContactController;
    $ctrl->index();
    exit;
}

// Page d'accueil par défaut
else {
    $ctrl = new AccueilController;
    $ctrl->index();
    exit;
}
