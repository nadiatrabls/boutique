<?php
namespace App;
use PDO;
use PDOStatement;

class Database
{
  private $dsn="mysql:dbname=boutique;host=localhost";
  private $login="root";
  private $password="";

  private $pdo;

  public function __construct(){

    $this->pdo = new PDO($this->dsn,$this->login,$this->password);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
}

  public function requete(string $query,array $params=[]): PDOStatement{
    
    if($params){

      $req=$this->pdo->prepare($query);
      $req->execute($params);
    }
    else{

      $req=$this->pdo->query($query);

    }

    return $req;

  }

}