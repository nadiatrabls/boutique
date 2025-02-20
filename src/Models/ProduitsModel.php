<?php
namespace Boutique\Models;

use App\Database;
use PDO;

class ProduitsModel extends Database
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = new Database();
    }

    // ✅ Récupérer tous les produits
    public function tousLesProduits()
    {
        return $this->db->requete("
            SELECT p.id, p.nom, p.description, p.prix, p.image, 
                   c.nom AS categorie_nom, sc.nom AS sous_categorie_nom
            FROM produits p
            LEFT JOIN categories c ON p.categorie_id = c.id
            LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les produits par catégorie
    public function produitsParCategorie($categorie_id)
    {
        return $this->db->requete("
            SELECT * FROM produits WHERE categorie_id = :categorie_id
        ", ['categorie_id' => $categorie_id])->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les produits d'une sous-catégorie
    public function produitsParSousCategorie($sous_categorie_id)
    {
        return $this->db->requete("
            SELECT * FROM produits WHERE sous_categorie_id = :sous_categorie_id
        ", ['sous_categorie_id' => $sous_categorie_id])->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les derniers produits
    public function getDerniersProduits($limit = 8)
    {
        $limit = intval($limit); // ✅ Assurer que LIMIT est bien un entier
        $sql = "SELECT * FROM produits ORDER BY id DESC LIMIT $limit";
        return $this->db->requete($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer un produit par ID
    public function getProduitById($id)
    {
        return $this->db->requete("
            SELECT p.*, c.nom AS categorie_nom 
            FROM produits p
            LEFT JOIN categories c ON p.categorie_id = c.id
            WHERE p.id = ?
        ", [$id])->fetch(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les autres produits (excluant un ID spécifique)
    public function getAutresProduits($id = null, $limit = 9)
    {
        $limit = intval($limit);
        if ($id) {
            return $this->db->requete("
                SELECT * FROM produits WHERE id != :id ORDER BY RAND() LIMIT $limit
            ", ['id' => $id])->fetchAll(PDO::FETCH_OBJ);
        } else {
            return $this->db->requete("
                SELECT * FROM produits ORDER BY RAND() LIMIT $limit
            ")->fetchAll(PDO::FETCH_OBJ);
        }
    }

    // ✅ Récupérer les produits exclusifs (⚠️ Vérifier si la colonne `exclusif` existe)
    public function getProduitsExclusifs($limit = 3)
    {
        $limit = intval($limit);
        return $this->db->requete("
            SELECT * FROM produits ORDER BY RAND() LIMIT $limit
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Compter le nombre de produits par catégorie
    public function countProduitsParCategorie($categorie_id)
    {
        return $this->db->requete("
            SELECT COUNT(*) as total FROM produits WHERE categorie_id = ?
        ", [$categorie_id])->fetchColumn();
    }

    // ✅ Compter le nombre de produits par sous-catégorie
    public function countProduitsParSousCategorie($sous_categorie_id)
    {
        return $this->db->requete("
            SELECT COUNT(*) as total FROM produits WHERE sous_categorie_id = ?
        ", [$sous_categorie_id])->fetchColumn();
    }

    // ✅ Récupérer toutes les catégories
    public function toutesLesCategories()
    {
        return $this->db->requete("
            SELECT c.*, 
                (SELECT COUNT(*) FROM produits p WHERE p.categorie_id = c.id) AS nombre_produits 
            FROM categories c
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer toutes les sous-catégories
    public function toutesLesSousCategories()
    {
        return $this->db->requete("
            SELECT sc.*, 
                (SELECT COUNT(*) FROM produits p WHERE p.sous_categorie_id = sc.id) AS nombre_produits 
            FROM sous_categories sc
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer toutes les pierres
    public function toutesLesPierres()
    {
        return $this->db->requete("
            SELECT pierre AS nom, COUNT(*) AS count 
            FROM produits 
            WHERE pierre IS NOT NULL AND pierre != ''
            GROUP BY pierre
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer toutes les couleurs
    public function toutesLesCouleurs()
    {
        return $this->db->requete("
            SELECT DISTINCT couleur AS nom, COUNT(*) AS count 
            FROM produits 
            GROUP BY couleur
        ")->fetchAll(PDO::FETCH_OBJ);
    }
    public function getCategorieNom($categorie_id)
{
    $sql = "SELECT nom FROM categories WHERE id = :id";
    $result = $this->db->requete($sql, ['id' => $categorie_id])->fetch(PDO::FETCH_OBJ);
    return $result ? $result->nom : "Catégorie inconnue";
}

}
