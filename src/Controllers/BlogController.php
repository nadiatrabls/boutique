<?php
namespace Boutique\Controllers;

use Boutique\Models\BlogModel;

use App\Database;

class BlogController extends Controller
{
    // Afficher la liste des produits dans le blog
    public function index() {
        $blogModel = new BlogModel();
        $produits = $blogModel->getAllProduits();
        $categories = $blogModel->getCategories();

        $this->render('blog', [
            'produits' => $produits,
            'categories' => $categories
        ]);
    }

    // Afficher les détails d'un produit
    public function details($id) {
        $blogModel = new BlogModel();
        $produit = $blogModel->getProduitById($id);
    
        // Vérification si le produit existe
        if (!$produit) {
            echo "Produit non trouvé.";
            exit;
        }
    
        include __DIR__ . '/../../views/single-blog.php';
    }
    


    public function getProduitsByCategorie($categorieId)
{
    $query = "
        SELECT p.* FROM produits p
        JOIN sous_categories sc ON p.sous_categorie_id = sc.id
        JOIN categories c ON sc.categorie_id = c.id
        WHERE c.id = :categorie_id
    ";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindValue(':categorie_id', $categorieId, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

    // Méthode pour filtrer par catégorie
    public function filtreParCategorie($categorieId) {
        $blogModel = new BlogModel(); // Création d'une instance de BlogModel
        $produits = $blogModel->getProduitsByCategorie($categorieId);
        $categories = $blogModel->getCategories();
        include __DIR__ . '/../../views/blog.php';

    } 
    
 
    // Afficher la liste des produits dans le blog
   

    // Afficher les détails d'un produit
   
}
