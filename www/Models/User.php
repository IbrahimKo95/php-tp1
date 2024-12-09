<?php

namespace App\Models;

use App\Core\SQL;
use PDO;

class User extends SQL
{
    protected ?int $id;
    protected string $email;
    protected string $fullname;
    protected string $password;
    protected string $created_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): void
    {
        $this->fullname = $fullname;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getOneByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $query = $this->pdo->prepare($sql);
        $query->execute(['email' => $email]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\User');
        return $query->fetch();
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\User');
        return $query->fetch();
    }

    public function checkPassword($hashed_password) {
        return password_verify($hashed_password, $this->password);
    }

    public function insert($email, $fullname, $password) {
        try {
            $sql = "INSERT INTO users (email, fullname, password) VALUES (:email, :fullname, :password)";
            $query = $this->pdo->prepare($sql);
            $query->execute([
                'email' => $email,
                'fullname' => $fullname,
                'password' => $password
            ]);
            return true;
        } catch (\PDOException $e) {
            return throw new \PDOException($e->getMessage());
        }
    }


}