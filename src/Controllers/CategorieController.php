<?php
namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;

class CategorieController extends Controller
{
    private $produitsModel;

    public function __construct()
    {
        $this->produitsModel = new ProduitsModel();
    }
    public function afficherProduitsParCategorie()
{
    $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

    $produitsModel = new ProduitsModel();
    $categories = $produitsModel->toutesLesCategories();

    if ($id) {
        // Si un ID est fourni, récupérer les produits de cette catégorie
        $produits = $produitsModel->produitsParCategorie($id);
        $categorie_nom = $produitsModel->getCategorieNom($id);
    } else {
        // Si aucun ID, récupérer tous les produits
        $produits = $produitsModel->tousLesProduits();
        $categorie_nom = "Toutes les catégories";
    }

    $this->render('categorie', [
        'categories' => $categories,
        'produits' => $produits,
        'categorie_nom' => $categorie_nom
    ]);
}

    
    
   

    private function getCategorieNom($categorie_id)
    {
        // Vérification depuis la base de données
        return $this->produitsModel->getCategorieNom($categorie_id) ?? "Catégorie inconnue";
    }
}
