<?php
namespace Boutique\Models;

use PDO;

class UserModel extends Model
{
    /**
     * Récupère un utilisateur par son nom d'utilisateur
     */
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Récupère un utilisateur par son email
     */
    public function getUserByEmail($email)
{
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    return $stmt->fetch();
}


    /**
     * Crée un nouvel utilisateur
     */
    public function createUser($username, $email, $password)
    {
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        $query->execute();
    }
}
