<?php
namespace Boutique\Controllers;

use Boutique\Models\ProduitsModel;

class SingleProductController extends Controller {
    
    public function details($id) {
        $produitsModel = new ProduitsModel();
        
        // Récupérer le produit actuel
        $produit = $produitsModel->getProduitById($id);

        // Vérifier si le produit existe
        if (!$produit) {
            header("Location: /produits");
            exit();
        }

        // Récupérer les autres produits sauf celui en cours
        $autresProduits = $produitsModel->getAutresProduits($id);

        $this->render('single-product', [
            'produit' => $produit,
            'autresProduits' => $autresProduits
        ]);
    }
}
