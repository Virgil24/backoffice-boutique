<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel {

    private $name;
    private $subtitle;
    private $picture;
    private $home_order;

    public static function find($categoryId)
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM `category`
            WHERE `id` = :id';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $categoryId, PDO::PARAM_STR);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchObject(self::class);

        return $result;
    }
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }
    public static function findAllHomepage(){
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        
        return $categories;
    }
    public function insert(){
        $pdo = Database::getPDO();
        $sql = "
        INSERT INTO `category` (name, subtitle, picture)
        VALUES (:name, :subtitle, :picture)
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':subtitle', $this->subtitle, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);

        $executed = $pdoStatement->execute();

        $insertedRows = $pdoStatement->rowCount();

        if ($executed & $insertedRows === 1) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();
            // On retourne VRAI car l'ajout a  fonctionné
            return true;
        }
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }
    public function update(){
        $pdo = Database::getPDO();
        $sql = 'UPDATE `category`
            SET
                name = :name,
                subtitle = :subtitle,
                picture = :picture,
                home_order = :home_order,
                updated_at = NOW()
            WHERE id = :id';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':subtitle', $this->subtitle, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $pdoStatement->bindValue(':home_order', $this->home_order, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $executed = $pdoStatement->execute();
        $updatedRows = $pdoStatement->rowCount();

        // On retourne VRAI, si au moins une ligne modifiée
        if($executed && $updatedRows === 1){
            return true;
        }else{
            return false;
        };
    }
    public function delete(){
        $pdo = Database::getPDO();

        $sql = 'DELETE FROM category WHERE id = :id';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $pdoStatement->execute();
    }
    public static function resetHomeOrder() {
        $pdo = Database::getPdo();
        $sql = 'UPDATE `category` SET home_order = 0';

        return $pdoStatement = $pdo->exec($sql);

    }

    // GETTERS & SETTERS
    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function getHomeOrder()
    {
        return $this->home_order;
    }
 
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }
}
