<?php
namespace Boutique\Models;

use App\Database;

class ProduitsModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function tousLesProduits()  {

        return $this->db->requete('SELECT id, nom, prix, img FROM produits')->fetchAll();
    }

}