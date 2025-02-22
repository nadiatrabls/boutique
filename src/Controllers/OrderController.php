<?php

namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;
use Boutique\Models\OrderModel;

class OrderController extends Controller
{
    /**
     * Affichage de la page Checkout
     */
    public function index()
    {
        // Vérifie si la session est déjà démarrée, sinon la démarre
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $produitsModel = new ProduitsModel();
        $panier = $_SESSION['panier'] ?? [];
        $produitsPanier = [];
        $totalGeneral = 0;

        // Récupération des détails des produits dans le panier
        if (!empty($panier)) {
            foreach ($panier as $id => $quantite) {
                $produit = $produitsModel->getProduitById($id);
                if ($produit) {
                    $produit->quantite = $quantite;
                    $produit->total = $produit->prix * $quantite;
                    $totalGeneral += $produit->total;
                    $produitsPanier[] = $produit;
                }
            }
        }

        // ✅ Rendu de la page Checkout
        $this->render('checkout', [
            'produitsPanier' => $produitsPanier,
            'totalGeneral' => $totalGeneral
        ]);
    }

    /**
     * Valider la commande et enregistrer en base de données
     */
    public function validerCommande()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['panier'])) {
        header('Location: index.php?url=cart');
        exit;
    }

    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $email = $_POST['email'] ?? '';
    $total = $_POST['total'] ?? 0;
    $payment_method = $_POST['payment_method'] ?? 'check';

    if (empty($nom) || empty($prenom) || empty($adresse) || empty($telephone) || empty($email)) {
        $_SESSION['error'] = "Tous les champs doivent être remplis.";
        header('Location: index.php?url=checkout');
        exit;
    }

    $orderModel = new OrderModel();
    $orderId = $orderModel->ajouterCommande($nom, $prenom, $adresse, $telephone, $email, $total);

    foreach ($_SESSION['panier'] as $idProduit => $quantite) {
        $orderModel->ajouterProduitCommande($orderId, $idProduit, $quantite);
    }

    unset($_SESSION['panier']);

    if ($payment_method == 'paypal') {
        header('Location: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=votre_email_paypal&item_name=Commande+'.$orderId.'&amount='.$total.'&currency_code=EUR');
        exit;
    } else {
        header('Location: index.php?url=confirmation&id=' . $orderId);
        exit;
        
    }
}




    /**
     * Affichage de la page de confirmation
     */
   

     public function confirmation()
     {
         // Vérification de l'id de commande dans l'URL
         $orderId = $_GET['id'] ?? null;
         if (!$orderId) {
             echo "Aucune commande sélectionnée.";
             exit;
         }
     
         $orderModel = new OrderModel();
     
         // Récupérer les détails de la commande
         $order = $orderModel->getOrderById($orderId);
     
         // Vérifier si la commande existe
         if (!$order) {
             echo "Commande introuvable.";
             exit;
         }
     
         

     
     
         // Récupérer les articles de la commande
         $orderItems = $orderModel->getOrderItems($orderId);
     
         // Récupérer l'adresse de facturation
         $billing = $orderModel->getBillingAddress($orderId);
     
         // Récupérer l'adresse de livraison (même que la facturation ici)
         $shipping = $orderModel->getShippingAddress($orderId);

    // Calcul du sous-total
    $sous_total = $orderModel->calculerSousTotal($orderId);

    // Définir les frais de livraison (exemple : 5 € fixe)
    $livraison = 5.00;
     
         // Inclure la vue en passant les variables
    $this->render('confirmation', [
        'order' => $order,
        'orderItems' => $orderItems,
        'billing' => $billing,
        'shipping' => $shipping,
        'sous_total' => $sous_total,
        'livraison' => $livraison
    ]);
        
     
}


}