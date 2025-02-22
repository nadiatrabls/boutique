<?php
namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;

class CartController extends Controller
{
    /**
     * Affichage du panier
     */
    public function index()
    {
        // Démarrage sécurisé de la session
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
                    // ✅ Assurez-vous que le prix et la quantité sont bien des nombres
                    $produit->quantite = (int) $quantite;
                    $produit->prix = (float) $produit->prix;
                    $produit->total = $produit->prix * $produit->quantite;
                    $totalGeneral += $produit->total;
                    $produitsPanier[] = $produit;
                }
            }
        }

        // ✅ Rendu de la page Panier
        $this->render('cart', [
            'produitsPanier' => $produitsPanier,
            'totalGeneral' => number_format($totalGeneral, 2, ',', ' ')
        ]);
    }

    /**
     * Ajouter un produit au panier
     */
    public function ajouterAuPanier()
    {
        // Démarrage sécurisé de la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validation de l'ID et de la quantité
        $id = isset($_POST['produit_id']) ? (int) $_POST['produit_id'] : null;
        $quantite = isset($_POST['quantite']) ? (int) $_POST['quantite'] : 1;

        if ($id && $quantite > 0) {
            // ✅ Ajout sécurisé au panier
            if (!isset($_SESSION['panier'][$id])) {
                $_SESSION['panier'][$id] = $quantite;
            } else {
                $_SESSION['panier'][$id] += $quantite;
            }

            echo json_encode(['status' => 'success', 'message' => 'Produit ajouté au panier.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID de produit invalide ou quantité incorrecte.']);
        }
    }

    /**
     * Mettre à jour la quantité d'un produit dans le panier
     */
    public function updateQuantity()
    {
        // Démarrage sécurisé de la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validation de l'ID et de la quantité
        $id = isset($_POST['produit_id']) ? (int) $_POST['produit_id'] : null;
        $quantite = isset($_POST['quantite']) ? (int) $_POST['quantite'] : null;

        if ($id && $quantite > 0) {
            $_SESSION['panier'][$id] = $quantite;
            echo json_encode(['status' => 'success', 'message' => 'Quantité mise à jour.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID de produit invalide ou quantité incorrecte.']);
        }
    }

    /**
     * Supprimer un produit du panier
     */
    public function supprimerDuPanier()
    {
        // Démarrage sécurisé de la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Validation de l'ID
        $id = isset($_POST['produit_id']) ? (int) $_POST['produit_id'] : null;

        if ($id && isset($_SESSION['panier'][$id])) {
            unset($_SESSION['panier'][$id]);
            echo json_encode(['status' => 'success', 'message' => 'Produit supprimé du panier.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID de produit invalide.']);
        }
    }
}
