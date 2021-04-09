<?php

namespace App\Models;

abstract class CoreModel {
    
    protected $id;
    protected $created_at;
    protected $updated_at;

    public function getId() : int
    {
        return $this->id;
    }
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }
    // methode appliquable a tous les elements presents en BDD pour distinguer lorsque nous sommes en insert ou update
    public function save() {
        // si il n'y a pas d'id d'un de mes elements en BDD alors j'execute les methodes insert
        if(empty($this->id)){
            return $this->insert();
        }else {
            //si il y a un id deja present, l'element existe et donc on le met a jour
            return $this->update();
        }
    }
    // on oblige les classes enfant a avoir des methodes
    abstract public function insert();
    abstract public function update();
    abstract public function delete();
    abstract static public function findAll();
    abstract static public function find($id);
}
