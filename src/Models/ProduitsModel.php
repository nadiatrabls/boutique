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
            LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
            LEFT JOIN categories c ON sc.categorie_id = c.id
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les produits par Catégorie
    public function getProduitsParCategorie($categorieId)
    {
        $sql = "
            SELECT p.*, c.nom AS categorie_nom, sc.nom AS sous_categorie_nom
            FROM produits p
            LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
            LEFT JOIN categories c ON sc.categorie_id = c.id
            WHERE c.id = :categorie_id
        ";
        
        $params = [':categorie_id' => $categorieId];
        
        $query = $this->db->getPdo()->prepare($sql);
        $query->execute($params);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les produits par Sous-Catégorie
    public function getProduitsParSousCategorie($sousCategorieId)
    {
        $sql = "
            SELECT p.*, c.nom AS categorie_nom, sc.nom AS sous_categorie_nom
            FROM produits p
            LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
            LEFT JOIN categories c ON sc.categorie_id = c.id
            WHERE sc.id = :sous_categorie_id
        ";
        
        $params = [':sous_categorie_id' => $sousCategorieId];
        
        $query = $this->db->getPdo()->prepare($sql);
        $query->execute($params);
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les produits par Catégorie ET Sous-Catégorie
    // ✅ Récupérer les produits par Catégorie ET Sous-Catégorie
public function getProduitsParCategorieEtSousCategorie($categorieId, $sousCategorieId = null)
{
    // 🔥 Correction : Utilisation des jointures pour lier correctement les catégories et sous-catégories
    $sql = "SELECT p.*, c.nom AS categorie_nom, sc.nom AS sous_categorie_nom
            FROM produits p
            LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
            LEFT JOIN categories c ON sc.categorie_id = c.id
            WHERE c.id = :categorie_id";
    
    // 🔥 Correction : Filtrage strict des catégories et sous-catégories
    if ($sousCategorieId) {
        $sql .= " AND sc.id = :sous_categorie_id";
    }

    $params = [':categorie_id' => $categorieId];
    if ($sousCategorieId) {
        $params[':sous_categorie_id'] = $sousCategorieId;
    }

    $req = $this->requete($sql, $params);
    return $req->fetchAll(PDO::FETCH_OBJ);
}

    // ✅ Récupérer les produits par Pierre
    public function getProduitsParPierre($pierre)
    {
        return $this->db->requete("
            SELECT * FROM produits WHERE pierre = :pierre
        ", ['pierre' => $pierre])->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les produits par Couleur
    public function getProduitsParCouleur($couleur)
    {
        return $this->db->requete("
            SELECT * FROM produits WHERE couleur = :couleur
        ", ['couleur' => $couleur])->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer les produits exclusifs
    public function getProduitsExclusifs($limit = 3)
    {
        $limit = intval($limit);
        return $this->db->requete("
            SELECT * FROM produits WHERE exclusif = 1 ORDER BY RAND() LIMIT $limit
        ")->fetchAll(PDO::FETCH_OBJ);
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
    /**
     * Récupère les produits avec pagination
     *
     * @param int $limite  Nombre de produits à afficher par page
     * @param int $offset  Offset pour la pagination
     * @return array
     */
     /**
     * Récupère les produits avec pagination
     */
    public function getProduitsPagines($limite, $offset)
    {
        // 🚀 Utilisation directe de LIMIT et OFFSET
        $sql = "SELECT * FROM produits LIMIT $limite OFFSET $offset";
        $stmt = $this->getPdo()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Compte le nombre total de produits
     */
    public function countProduits()
    {
        $sql = "SELECT COUNT(*) as total FROM produits";
        $stmt = $this->getPdo()->query($sql);
        $result = $stmt->fetch();
        return $result->total;
    }

    /**
     * Récupère le nombre total de produits
     *
     * @return int
     */
    public function getNombreTotalProduits()
    {
        $sql = "SELECT COUNT(*) as total FROM produits";
        $stmt = $this->requete($sql);
        $result = $stmt->fetch();
        return $result->total ?? 0;
    }
    // ✅ Récupérer toutes les catégories
    public function toutesLesCategories()
    {
        return $this->db->requete("
            SELECT c.*, 
                (SELECT COUNT(*) FROM produits p 
                 LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id 
                 WHERE sc.categorie_id = c.id) AS nombre_produits 
            FROM categories c
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    // ✅ Récupérer toutes les sous-catégories
    public function toutesLesSousCategories()
    {
        return $this->db->requete("
            SELECT sc.*, 
                (SELECT COUNT(*) FROM produits p 
                 WHERE p.sous_categorie_id = sc.id) AS nombre_produits 
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
            SELECT couleur AS nom, COUNT(*) AS count 
            FROM produits 
            WHERE couleur IS NOT NULL AND couleur != ''
            GROUP BY couleur
        ")->fetchAll(PDO::FETCH_OBJ);
    }

   

    // ✅ Récupérer les derniers produits (par défaut, les 8 derniers)
public function getDerniersProduits($limit = 8)
{
    $limit = intval($limit); // Sécurisation de la limite
    $sql = "
        SELECT p.id, p.nom, p.description, p.prix, p.image, 
               c.nom AS categorie_nom, sc.nom AS sous_categorie_nom
        FROM produits p
        LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
        LEFT JOIN categories c ON sc.categorie_id = c.id
        ORDER BY p.date_creation DESC 
        LIMIT $limit
    ";

    return $this->db->requete($sql)->fetchAll(PDO::FETCH_OBJ);
}
// ✅ Récupérer les produits par catégorie
public function produitsParCategorie($categorieId)
{
    $sql = "
        SELECT p.id, p.nom, p.description, p.prix, p.image, 
               c.nom AS categorie_nom, sc.nom AS sous_categorie_nom
        FROM produits p
        LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
        LEFT JOIN categories c ON sc.categorie_id = c.id
        WHERE c.id = :categorie_id
    ";

    $query = $this->db->getPdo()->prepare($sql);
    $query->bindValue(':categorie_id', $categorieId, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_OBJ);
}
// ✅ Récupérer le nom de la catégorie par son ID
public function getCategorieNom($categorieId)
{
    $sql = "SELECT nom FROM categories WHERE id = :id";
    $query = $this->db->getPdo()->prepare($sql);
    $query->bindValue(':id', $categorieId, PDO::PARAM_INT);
    $query->execute();
    
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result ? $result->nom : "Catégorie inconnue";
}
// ✅ Récupérer un produit par ID
public function getProduitById($id)
{
    $sql = "
        SELECT p.*, 
               c.nom AS categorie_nom, 
               sc.nom AS sous_categorie_nom
        FROM produits p
        LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
        LEFT JOIN categories c ON sc.categorie_id = c.id
        WHERE p.id = :id
    ";
    
    $query = $this->db->getPdo()->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    
    return $query->fetch(PDO::FETCH_OBJ);
}
// ✅ Compter le nombre de produits par catégorie
// ✅ Compter le nombre de produits par catégorie
public function countProduitsParCategorie($categorie_id)
{
    $sql = "
        SELECT COUNT(*) as total 
        FROM produits p
        LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id
        LEFT JOIN categories c ON sc.categorie_id = c.id
        WHERE c.id = :categorie_id
    ";

    $query = $this->db->getPdo()->prepare($sql);
    $query->bindValue(':categorie_id', $categorie_id, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchColumn();
}

// ✅ Compter le nombre de produits par sous-catégorie
// ✅ Compter le nombre de produits par sous-catégorie
public function countProduitsParSousCategorie($sous_categorie_id)
{
    $sql = "
        SELECT COUNT(*) as total 
        FROM produits p
        WHERE p.sous_categorie_id = :sous_categorie_id
    ";

    $query = $this->db->getPdo()->prepare($sql);
    $query->bindValue(':sous_categorie_id', $sous_categorie_id, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchColumn();
}


}
