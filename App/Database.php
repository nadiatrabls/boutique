<?php
namespace App;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private $dsn = "mysql:dbname=boutique;host=localhost";
    private $login = "root";
    private $password = "";
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->login, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Exécute une requête SQL avec ou sans paramètres.
     * @param string $query La requête SQL
     * @param array $params Les paramètres optionnels pour la requête
     * @return PDOStatement|false Retourne l'objet PDOStatement ou false en cas d'échec
     */
    public function requete(string $query, array $params = []): PDOStatement|false
    {
        try {
            if (!empty($params)) {
                $req = $this->pdo->prepare($query);

                // 🚀 Correction : Sécurisation des paramètres numériques pour LIMIT
                foreach ($params as $key => &$val) {
                    if (preg_match('/\bLIMIT\b/i', $query) && is_numeric($val)) {
                        $val = (int) $val; // Conversion stricte en entier
                    }
                }

                $req->execute($params);
            } else {
                $req = $this->pdo->query($query);
            }

            return $req;
        } catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }

    /**
     * Retourne l'instance PDO pour des requêtes avancées si nécessaire.
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
