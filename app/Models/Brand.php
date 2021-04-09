<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Brand extends CoreModel {
    
    private $name;
    private $footer_order;

    public static function find($brandId)
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM `brand`
            WHERE `id` = :id';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $brandId, PDO::PARAM_STR);
        $pdoStatement->execute();
        $result = $pdoStatement->fetchObject(self::class);

        return $result;
       
    }

    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `brand`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }

    public function findAllFooter()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM brand
            WHERE footer_order > 0
            ORDER BY footer_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $brands = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $brands;
    }

    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = "
        INSERT INTO `brand` (name)
        VALUES (:name)
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);

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

    public function update()
    {
        $pdo = Database::getPDO();
        $sql = 'UPDATE `brand`
            SET
                name = :name,
                updated_at = NOW()
            WHERE id = :id';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
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
        $sql = 'DELETE FROM `brand` WHERE id = :id';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $pdoStatement->execute();
    }
    //GETTERS & SETTERS

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getFooterOrder()
    {
        return $this->footer_order;
    }


    public function setFooterOrder(int $footer_order)
    {
        $this->footer_order = $footer_order;
    }
}
