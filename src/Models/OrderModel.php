<?php
namespace Boutique\Models;
use PDO;

class OrderModel extends Model
{
    public function ajouterCommande($nom, $prenom, $adresse, $telephone, $email, $total)
    {
        $sql = "INSERT INTO commandes (nom, prenom, adresse, telephone, email, total, date_commande)
                VALUES (:nom, :prenom, :adresse, :telephone, :email, :total, NOW())";

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':adresse', $adresse, PDO::PARAM_STR);
        $query->bindValue(':telephone', $telephone, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':total', $total, PDO::PARAM_STR);
        $query->execute();

        return $this->pdo->lastInsertId();
    }

    public function ajouterProduitCommande($idCommande, $idProduit, $quantite)
    {
        $sql = "INSERT INTO produits_commandes (commande_id, produit_id, quantite)
                VALUES (:commande_id, :produit_id, :quantite)";

        $query = $this->pdo->prepare($sql);
        $query->bindValue(':commande_id', $idCommande, PDO::PARAM_INT);
        $query->bindValue(':produit_id', $idProduit, PDO::PARAM_INT);
        $query->bindValue(':quantite', $quantite, PDO::PARAM_INT);
        $query->execute();
    }

     // Récupérer les détails de la commande
     public function getOrderById($orderId)
     {
         $sql = "SELECT id, total, date_commande
                 FROM commandes
                 WHERE id = :orderId";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(['orderId' => $orderId]);
         return $stmt->fetch();
     }
     
 
     // Récupérer les articles de la commande
     public function getOrderItems($orderId)
     {
         $sql = "SELECT pc.quantite, p.nom, p.prix, (pc.quantite * p.prix) AS total
                 FROM produits_commandes pc
                 JOIN produits p ON pc.produit_id = p.id
                 WHERE pc.commande_id = :orderId";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(['orderId' => $orderId]);
         return $stmt->fetchAll();
     }
     
     public function getAllOrdersByUser($email)
     {
         $sql = "SELECT * 
                 FROM commandes 
                 WHERE email = :email
                 ORDER BY date_commande DESC";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(['email' => $email]);
         return $stmt->fetchAll();
     }
     
   
    /**
 * Récupère les commandes par utilisateur
 */
public function getCommandesByUserId($userId)
{
    $query = "SELECT * FROM commandes WHERE user_id = :user_id";
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_OBJ); // 🔥 Utilisation correcte de FETCH_OBJ
    return $stmt->fetchAll();
}





          
     // Récupérer l'adresse de facturation
     public function getBillingAddress($orderId)
     {
         $sql = "SELECT nom, prenom, adresse, telephone, email
                 FROM commandes
                 WHERE id = :orderId";
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute(['orderId' => $orderId]);
         return $stmt->fetch();
     }
     
     public function calculerSousTotal($orderId)
{
    $sql = "SELECT SUM(p.prix * pc.quantite) AS sous_total
            FROM produits p
            JOIN produits_commandes pc ON p.id = pc.produit_id
            WHERE pc.commande_id = :orderId";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['orderId' => $orderId]);
    $result = $stmt->fetch();
    return $result->sous_total ?? 0;
}

     
 
     // Récupérer l'adresse de livraison
     public function getShippingAddress($orderId)
     {
         return $this->getBillingAddress($orderId);
     }
     
}
