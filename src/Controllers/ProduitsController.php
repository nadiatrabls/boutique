<?php
namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;

class ProduitsController extends Controller
{
    public function index()
    {
        $produitsModel = new ProduitsModel();
        
        // 🔹 Récupération des catégories, sous-catégories, pierres et couleurs
        $categories = $produitsModel->toutesLesCategories() ?? [];
        $sousCategories = $produitsModel->toutesLesSousCategories() ?? [];
        $pierres = $produitsModel->toutesLesPierres() ?? [];
        $couleurs = $produitsModel->toutesLesCouleurs() ?? [];

        // ✅ Ajouter le nombre de produits à chaque catégorie et sous-catégorie
        foreach ($categories as $categorie) {
            $categorie->nombre_produits = $produitsModel->countProduitsParCategorie($categorie->id);
        }

        foreach ($sousCategories as $sousCategorie) {
            $sousCategorie->nombre_produits = $produitsModel->countProduitsParSousCategorie($sousCategorie->id);
        }

        // ✅ Vérifier si une catégorie ou une sous-catégorie est sélectionnée
        if (isset($_GET['categorie'])) {
            $touslesproduits = $produitsModel->produitsParCategorie($_GET['categorie']);
        } elseif (isset($_GET['sous-categorie'])) {
            $touslesproduits = $produitsModel->produitsParSousCategorie($_GET['sous-categorie']);
        } else {
            $touslesproduits = $produitsModel->tousLesProduits();
        }

        // 🔥 Récupération des autres produits
        $autresProduits = $produitsModel->getAutresProduits(9);

        // 🎯 Récupération des produits exclusifs
        $produitsExclusifs = $produitsModel->getProduitsExclusifs(3);

        // ✅ Rendu de la page Produits
        $this->render('produits', [
            'touslesproduits' => $touslesproduits,
            'categories' => $categories,
            'sousCategories' => $sousCategories,
            'pierres' => $pierres,
            'couleurs' => $couleurs,
            'autresProduits' => $autresProduits,
            'produitsExclusifs' => $produitsExclusifs
        ]);
    }

    /**
     * ✅ Ajout d'un produit au panier
     */
    public function ajouterAuPanier()
    {
        session_start(); // Assurez-vous que la session est démarrée

        $produitId = isset($_POST['produit_id']) ? (int)$_POST['produit_id'] : null;

        if ($produitId) {
            // Vérifie si le panier existe déjà dans la session
            if (!isset($_SESSION['panier'])) {
                $_SESSION['panier'] = [];
            }

            // Ajoute le produit au panier
            if (!in_array($produitId, $_SESSION['panier'])) {
                $_SESSION['panier'][] = $produitId;
                echo json_encode(['success' => true, 'message' => 'Produit ajouté au panier']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Produit déjà dans le panier']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Produit non trouvé']);
        }
        exit;
    }

    /**
     * ✅ Ajout d'un produit aux favoris
     */
    public function ajouterAuxFavoris()
{
    if (isset($_POST['produit_id'])) {
        $produitId = (int)$_POST['produit_id'];

        // Vérifie si le produit existe
        $produitsModel = new ProduitsModel();
        $produit = $produitsModel->getProduitById($produitId);

        if ($produit) {
            // Initialise la liste des favoris s'il n'existe pas encore
            if (!isset($_SESSION['favoris'])) {
                $_SESSION['favoris'] = [];
            }

            // Ajoute le produit aux favoris
            if (!in_array($produitId, $_SESSION['favoris'])) {
                $_SESSION['favoris'][] = $produitId;
                echo json_encode(['status' => 'success', 'message' => 'Produit ajouté aux favoris !']);
                exit;
            } else {
                echo json_encode(['status' => 'info', 'message' => 'Ce produit est déjà dans vos favoris.']);
                exit;
            }
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
