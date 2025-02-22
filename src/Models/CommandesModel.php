<?php
namespace Boutique\Models;

use App\Database;
use PDO;

class CommandesModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * ✅ Récupérer les détails du suivi de la commande
     */
    public function getOrderTrackingDetails($orderId, $email)
    {
        $sql = "SELECT c.id, c.status
                FROM commandes c
                INNER JOIN clients cl ON c.client_id = cl.id
                WHERE c.id = :orderId AND cl.email = :email";

        $query = $this->getPdo()->prepare($sql);
        $query->bindValue(':orderId', $orderId, PDO::PARAM_INT);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
