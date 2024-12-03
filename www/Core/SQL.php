<?php

namespace App\Core;

use PDO;
use PDOException;

class SQL
{
    protected PDO $pdo; // PDO instance for database interaction

    // Private constructor to prevent direct instantiation
    public function __construct()
    {
        try {
            // Initialize the PDO connection (database connection setup)
            $this->pdo = new PDO("mysql:host=mariadb;dbname=esgi", "esgi", "esgipwd");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error with database connection: " . $e->getMessage());
        }
    }
    public function getOneById(string $table,int $id): array
    {
       $queryPrepared = $this->pdo->prepare("SELECT * FROM ".$table." WHERE id=:id");
       $queryPrepared->execute([
               "id"=>$id
           ]);
       return $queryPrepared->fetch();
    }
}
