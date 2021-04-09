<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Tag extends CoreModel {
    protected $name;

    public static function find($tag_id){

    }
    public static function findAll(){

    }
    protected function insert(){

    }
    protected function update(){

    }
    protected function delete(){

    }
    // produits associé au tag
    public function getProduct(){

    }
    
  

// GETTER & SETTERS
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
