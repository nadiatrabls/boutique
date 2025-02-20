<?php
namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;

class AccueilController extends Controller
{
    public function index()
{
    $produitsModel = new ProduitsModel();
    
    // Récupération des derniers produits
    $derniersProduits = $produitsModel->getDerniersProduits();
    
    // Récupération des produits exclusifs (3 max)
    $produitsExclusifs = $produitsModel->getProduitsExclusifs(3);
    
    $this->render('accueil', [
        'derniersProduits' => $derniersProduits,
        'produitsExclusifs' => $produitsExclusifs
    ]);
}

}


