<?php

namespace App\Models;
use App\Utils\Database;
use PDO;

class AppUser extends CoreModel {
    protected $email;
    protected $password;
    protected $firstname;
    protected $lastname;
    protected $role;
    protected $status;

    public static function find($user_id){
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM `app_user`
            WHERE `id` = :id';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $user_id, PDO::PARAM_STR);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchObject(self::class);

        return $result;
    }
    public static function findAll(){
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }
    //recuperer un user par son email pour l'authentification
    public static function findByEmail($email){
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM `app_user`
            WHERE `email` = :email';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchObject(self::class);

        return $result;
    }
    public function insert(){
        $pdo = Database::getPDO();

        $sql = 'INSERT INTO `app_user` (
            `email`,
            `password`,
            `firstname`,
            `lastname`,
            `role`,
            `status`
        ) VALUES (
            :email,
            :password,
            :firstname,
            :lastname,
            :role,
            :status
        )';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);

        $executed = $pdoStatement->execute();
        $insertedRows = $pdoStatement->rowCount();

        if ($executed && $insertedRows === 1) {

            $this->id = $pdo->lastInsertId();
            return true;
        }
    }

    public function delete(){
        $pdo = Database::getPDO();
        $sql = 'DELETE FROM app_user WHERE id = :id';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $pdoStatement->execute();
    }

    public function update(){
        $pdo = Database::getPDO();

        $sql = 'UPDATE `app_user`
                SET
                    email = :email,
                    password = :password,
                    firstname = :firstname,
                    lastname = :lastname,
                    role = :role,
                    status = :status,
                    updated_at = NOW()
                WHERE
                    id = :id';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $executed = $pdoStatement->execute();
        $updatedRows = $pdoStatement->rowCount();

        if ($executed && $updatedRows === 1) {
            return true;
        }

        return false;
    }
    
    // GETTERS & SETTERS
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}