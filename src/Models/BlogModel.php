<?php
namespace Boutique\Models;

use App\Database;
use PDO;

class BlogModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getPdo(); // Utilisation correcte de getPdo()
    }

    // Récupérer tous les produits (anciennement articles)
    public function getAllProduits()
    {
        $query = "SELECT * FROM produits";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll();
    }

    // Récupérer un produit par ID
   public function getProduitById($id) {
    $sql = "SELECT * FROM produits WHERE id = :id";
    $query = $this->pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_OBJ);
}

    

    // Récupérer les catégories
    public function getCategories()
    {
        $query = "SELECT * FROM categories";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll();
    }

    // Récupérer les produits par catégorie
    // Récupérer les produits par catégorie
    public function getProduitsByCategorie($categorieId)
    {
        $query = "SELECT * FROM produits WHERE sous_categorie_id = :sous_categorie_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':sous_categorie_id', $categorieId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    

    
}
