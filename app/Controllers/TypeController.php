<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController {
    public function list() {    
        $allTypes = Type::findAll();
        $this->show('type/list',[
            'allTypes' => $allTypes
        ]);
    }
    public function add(){
        $this->show('type/create-update',[
            'mode'=>'create'
        ]);
    }
    public function update($type_id){
        
        $type = Type::find($type_id);
        if(empty($type)){
            //si le type n'existe pas, on renvoi 404
            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }
        $this->show('type/create-update', [
            'type' => $type,
            'mode'=> 'update',
        ]);
    }
    public function createEdit($type_id = null){
        
        if(is_null($type_id)){
            // mode ajout type
            $mode = 'create';
        } else {
            // mode mise a jour type
            $mode = 'update';
            $type = Type::find($type_id);
            if(empty($type)){
                //si le type n'existe pas, on renvoi 404
                header('HTTP/1.0 404 Not Found');
                return $this->show('error/err404');
            }
        }
    
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        
        $errorList = [];

        // test des erreurs
        if(empty($name)) {
            $errorList[]= 'Le nom du type est vide';
        }
        if(strlen($name) < 3){
            $errorList[]= 'Le nom du type doit comporter 3 caractères minimum';
        }

        //si pas d'erreurs ...
        if(empty($errorList)){
            if($mode === 'create'){
                //en creation, je cree une nouvelle instance
                $type = new type();
            }
            //sinon j'ai deja une instance que je modifie

            $type->setName($name);
            
            $queryExecuted = $type->save();
            if($queryExecuted){

                global $router;
                header('Location: '.$router->generate('type-list'));
                //logique terminée, on coupe le code
                return;
            } else {
                $errorList[]= 'La sauvegarde a échoué, merci de retenter';
            }
        }
        if(!empty($errorList)){

            //si erreur, on créer une nouvelle instance avec les données saisies par l'utilisateur, sans filtre
            $type = new Type();
            $type->setName(filter_input(INPUT_POST, 'name'));

            $this->show('type/create-update',[
                'type'=>$type,
                'errorList'=>$errorList,
                'mode'=> $mode
            ]);
        }
    }
    public function delete($type_id)
    {
        $type = Type::find($type_id);
        if (empty($type)) {
            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }
        $type->delete();
        global $router;
        header('Location: '.$router->generate('type-list'));
    }
}