<?php

require '../vendor/autoload.php';

use Boutique\Controllers\AccueilController;
use Boutique\Controllers\BlogController;
use Boutique\Controllers\ProduitsController;
use Boutique\Controllers\UserController;
use Boutique\Controllers\CartController;
use Boutique\Controllers\OrderController;

use Boutique\Controllers\ContactController;
use Boutique\Controllers\SingleProductController;
use Boutique\Controllers\CategorieController;
use Boutique\Controllers\TrackingController;

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
// Route pour afficher le formulaire de connexion
elseif ($url === 'login') {
    $ctrl = new UserController();
    $ctrl->index();
    exit;
}



// Route pour afficher le formulaire d'inscription
elseif ($url === 'register') {
    $ctrl = new UserController();
    $ctrl->register();
    exit;
}



// Route pour la déconnexion
elseif ($url === 'logout') {
    $ctrl = new UserController();
    $ctrl->logout();
    exit;
}


// Route pour l'inscription
 elseif ($url == 'register') {
    $ctrl = new UserController;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ctrl->inscription(); // 🔥 Appel à la méthode d'inscription
    } else {
        $ctrl->register(); // 🔥 Affichage de la page d'inscription
    }
    exit;
}

// Routes pour l'utilisateur
 elseif ($url == 'login') {
    $ctrl = new UserController;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ctrl->login(); // 🔥 Appel à la méthode login()
    } else {
        $ctrl->index(); // 🔥 Affichage de la page de connexion
    }
    exit;
}


// Routes pour le panier
elseif ($url == 'cart') {
    $ctrl = new CartController;
    $ctrl->index();
    exit;
} elseif ($url == 'ajouter-au-panier') {
    $ctrl = new CartController;
    $ctrl->ajouterAuPanier();
    exit;
} elseif ($url == 'update-quantity') {
    $ctrl = new CartController;
    $ctrl->updateQuantity();
    exit;
} elseif ($url == 'supprimer-du-panier') {
    $ctrl = new CartController;
    $ctrl->supprimerDuPanier();
    exit;
}

// Routes pour les favoris
// Ajouter un produit aux favoris
elseif ($url == 'ajouter-aux-favoris') {
    $ctrl = new ProduitsController;
    $ctrl->ajouterAuxFavoris();
    exit;
}

// Affichage des favoris
elseif ($url == 'wishlist') {
    $ctrl = new ProduitsController;
    $ctrl->afficherFavoris();
    exit;
}

// Suppression d'un produit des favoris
elseif ($url == 'supprimer-des-favoris') {
    $ctrl = new ProduitsController;
    $ctrl->supprimerDesFavoris();
    exit;
}
elseif ($url === 'tracking') {
    $ctrl = new TrackingController;
    $ctrl->index();
    exit;
}


// Routes pour la commande
// Route pour afficher la page de Checkout
elseif ($url === 'checkout') {
    $ctrl = new OrderController;
    $ctrl->index();
    exit;
}

// Route pour valider la commande
elseif ($url === 'valider-commande') {
    $ctrl = new OrderController;
    $ctrl->validerCommande();
    exit;
}

// Route pour afficher la page de confirmation
// public/index.php




// Page principale du blog
// Route principale du blog (affiche tous les produits)
// Route pour afficher la liste des articles (produits)
elseif ($url === 'blog') {
    $ctrl = new BlogController();
    $ctrl->index();
    exit;
}

// Route pour afficher le détail d'un article (produit)
elseif ($url === 'single-blog') {
    $ctrl = new BlogController();
    $ctrl->details($_GET['id']);
    exit;
}


// Route pour filtrer les produits par catégorie dans le blog
// Route pour filtrer les produits par catégorie
elseif ($url === 'blog-categorie') {
    $ctrl = new BlogController();
    $ctrl->filtreParCategorie($_GET['id']);
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

