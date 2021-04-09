<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Product extends CoreModel {
    
    private $name;
    private $description;
    private $picture;
    private $price = 0.0;
    private $rate = 0;
    private $status = 0;
    private $brand_id;
    private $category_id;
    private $type_id;
    
    public static function find($productId)
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM `product`
            WHERE `id` = :id';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $productId, PDO::PARAM_STR);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchObject(self::class);

        return $result;
    }
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }

    public static function findLastFive()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM product
            ORDER BY id DESC
            LIMIT 5
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $categories;
    }
    public function insert(){
        $pdo = Database::getPDO();
        $sql = "
        INSERT INTO `product` (name, description, picture, price, rate, status, brand_id, category_id, type_id)
        VALUES (:name, :description, :picture, :price, :rate, :status, :brand_id, :category_id, :type_id)
        ";

        
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $pdoStatement->bindValue(':price', $this->price, PDO::PARAM_STR);
        $pdoStatement->bindValue(':rate', $this->rate, PDO::PARAM_INT);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':brand_id', $this->brand_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':type_id', $this->type_id, PDO::PARAM_INT);

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
        $sql ='UPDATE `product`
        SET
            name = :name,
            description = :description,
            picture = :picture,
            price = :price,
            rate = :rate,
            status = :status,
            brand_id = :brand_id,
            category_id = :category_id,
            rate = :rate,
            type_id = :type_id,
            updated_at = NOW()
        WHERE id = :id';

        
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $pdoStatement->bindValue(':price', $this->price, PDO::PARAM_STR);
        $pdoStatement->bindValue(':rate', $this->rate, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':brand_id', $this->brand_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':type_id', $this->type_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $executed = $pdoStatement->execute();
        $updatedRows = $pdoStatement->rowCount();

        if ($executed & $updatedRows === 1) {    
            // On retourne VRAI car l'ajout a  fonctionné
            return true;
        }
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }
    public function delete(){
        $pdo = Database::getPDO();
        $sql = 'DELETE FROM product WHERE id = :id';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $pdoStatement->execute();
    }
    public function getTags(){
        $pdo = Database::getPDO();
        $sql = 'SELECT tag.* FROM tag
        INNER JOIN product_has_tag
        ON product_has_tag.tag_id = tag.id
        WHERE product_has_tag.product_id = :product_id;';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':product_id', $this->id, PDO::PARAM_INT);

        $pdoStatement->execute();
        $result = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        return $result;
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

    public function getDescription()
    {
        return $this->description;
    }
 
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function getBrandId()
    {
        return $this->brandId;
    }

    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    public function getTypeId()
    {
        return $this->type_id;
    }

    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }
}
