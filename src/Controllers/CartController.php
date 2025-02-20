<?php
namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;

class CartController extends Controller
{
    public function ajouterAuPanier()
    {
        // Vérifie si l'ID du produit est passé en POST
        if (isset($_POST['produit_id'])) {
            $produitId = (int)$_POST['produit_id'];
            
            $produitsModel = new ProduitsModel();
            $produit = $produitsModel->getProduitById($produitId);

            // Vérifie si le produit existe
            if ($produit) {
                // Initialise le panier s'il n'existe pas encore
                if (!isset($_SESSION['panier'])) {
                    $_SESSION['panier'] = [];
                }

                // Ajoute le produit au panier
                if (isset($_SESSION['panier'][$produitId])) {
                    $_SESSION['panier'][$produitId]['quantite']++;
                } else {
                    $_SESSION['panier'][$produitId] = [
                        'id' => $produit->id,
                        'nom' => $produit->nom,
                        'prix' => $produit->prix,
                        'quantite' => 1,
                        'image' => $produit->image
                    ];
                }

                // Réponse JSON de succès
                echo json_encode(['status' => 'success', 'message' => 'Produit ajouté au panier !']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Produit non trouvé.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID du produit manquant.']);
            exit;
        }
    }
}
