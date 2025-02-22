<?php
namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;

class ProduitsController extends Controller
{
    /**
     * ✅ Affichage des produits avec filtres et sous-catégories
     */
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

        // 🔥 Gestion des filtres et des sous-catégories
        $categorie = isset($_GET['categorie']) ? intval($_GET['categorie']) : null;
        $sousCategorie = isset($_GET['sous-categorie']) ? intval($_GET['sous-categorie']) : null;
        $pierre = isset($_GET['pierre']) ? $_GET['pierre'] : null;
        $couleur = isset($_GET['couleur']) ? $_GET['couleur'] : null;

        // 🔍 Appliquer les filtres dynamiques
        if ($categorie && $sousCategorie) {
            // 🟢 Cas 1 : Catégorie et Sous-catégorie sélectionnées
            $touslesproduits = $produitsModel->getProduitsParCategorieEtSousCategorie($categorie, $sousCategorie);
        } elseif ($categorie) {
            // 🟡 Cas 2 : Seulement Catégorie sélectionnée
            $touslesproduits = $produitsModel->getProduitsParCategorie($categorie);
        } elseif ($sousCategorie) {
            // 🔵 Cas 3 : Seulement Sous-catégorie sélectionnée
            $touslesproduits = $produitsModel->getProduitsParSousCategorie($sousCategorie);
        } elseif ($pierre) {
            // 🔵 Cas 4 : Filtre par Pierre
            $touslesproduits = $produitsModel->getProduitsParPierre($pierre);
        } elseif ($couleur) {
            // 🔴 Cas 5 : Filtre par Couleur
            $touslesproduits = $produitsModel->getProduitsParCouleur($couleur);
        } else {
            // 🟠 Cas 6 : Aucun filtre
            $touslesproduits = $produitsModel->tousLesProduits();
        }

        // 🔥 Récupération des autres produits
        $autresProduits = $produitsModel->getAutresProduits(9);

        // 🎯 Récupération des produits exclusifs
        $produitsExclusifs = $produitsModel->getProduitsExclusifs(3);

         // Nombre de produits par page
         $limite = 6;

         // Calcul de la page actuelle et de l'offset
         $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
         $offset = ($page - 1) * $limite;
         $model = new ProduitsModel();
        // ✅ Récupération des produits paginés
        $produits = $model->getProduitsPagines($limite, $offset);

        // ✅ Calcul du nombre total de pages
        $totalProduits = $model->countProduits();
        $totalPages = ceil($totalProduits / $limite);

        $this->render('produits', [
            'touslesproduits' => $touslesproduits,
            'categories' => $categories,
            'sousCategories' => $sousCategories,
            'pierres' => $pierres,
            'couleurs' => $couleurs,
            'autresProduits' => $autresProduits,
            'produitsExclusifs' => $produitsExclusifs,
            'produits' => $produits,
            'page' => $page,
            'totalPages' => $totalPages
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
     * ✅ Affichage des favoris
     */
    public function afficherFavoris()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $produitsModel = new ProduitsModel();
        $favoris = $_SESSION['favoris'] ?? [];
        $produitsFavoris = [];
    
        if (!empty($favoris)) {
            foreach ($favoris as $id) {
                $produit = $produitsModel->getProduitById($id);
                if ($produit) {
                    $produitsFavoris[] = $produit;
                }
            }
        }
    
        $this->render('wishlist', [
            'produitsFavoris' => $produitsFavoris
        ]);
    }
    
    /**
     * ✅ Suppression des favoris
     */
    public function supprimerDesFavoris()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_POST['produit_id'];

        if (($key = array_search($id, $_SESSION['favoris'])) !== false) {
            unset($_SESSION['favoris'][$key]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    /**
     * ✅ Ajout d'un produit aux favoris
     */
    public function ajouterAuxFavoris()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id = $_POST['produit_id'];

        if (!isset($_SESSION['favoris'])) {
            $_SESSION['favoris'] = [];
        }

        if (!in_array($id, $_SESSION['favoris'])) {
            $_SESSION['favoris'][] = $id;
            echo json_encode([
                'status' => 'success',
                'message' => 'Produit ajouté aux favoris.'
            ]);
        } else {
            echo json_encode([
                'status' => 'info',
                'message' => 'Ce produit est déjà dans vos favoris.'
            ]);
        }
        exit;
    }
}
