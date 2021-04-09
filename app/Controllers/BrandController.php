<?php

namespace App\Controllers;

use App\Models\Brand;

class BrandController extends CoreController {
    public function list() {
        $allBrands = Brand::findAll();
        $this->show('brand/list',[
            'allBrands' => $allBrands
        ]);
    }
    public function add(){
        $this->show('brand/create-update',[
            'mode'=>'create'
        ]);
    }
    public function update($brand_id){
        
        $brand = Brand::find($brand_id);
        if(empty($brand)){
            //si la marque n'existe pas, on renvoi 404
            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }
        $this->show('brand/create-update', [
            'brand' => $brand,
            'mode'=> 'update',
        ]);
    }
    public function createEdit($brand_id = null){
        
        if(is_null($brand_id)){
            // mode ajout marque
            $mode = 'create';
        } else {
            // mode mise a jour marque
            $mode = 'update';
            $brand = Brand::find($brand_id);
            if(empty($brand)){
                //si la marque n'existe pas, on renvoi 404
                header('HTTP/1.0 404 Not Found');
                return $this->show('error/err404');
            }
        }
    
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        
        $errorList = [];

        // test des erreurs
        if(empty($name)) {
            $errorList[]= 'Le nom de la marque est vide';
        }
        if(strlen($name) < 3){
            $errorList[]= 'Le nom de la marque doit comporter 3 caractères minimum';
        }

        //si pas d'erreurs ...
        if(empty($errorList)){
            if($mode === 'create'){
                //en creation, je cree une nouvelle instance
                $brand = new Brand();
            }
            //sinon j'ai deja une instance que je modifie

            $brand->setName($name);
            
            $queryExecuted = $brand->save();
            if($queryExecuted){

                global $router;
                header('Location: '.$router->generate('brand-list'));
                //logique terminée, on coupe le code
                return;
            } else {
                $errorList[]= 'La sauvegarde a échoué, merci de retenter';
            }
        }
        if(!empty($errorList)){

            //si erreur, on créer une nouvelle instance avec les données saisies par l'utilisateur, sans filtre
            $brand = new Brand();
            $brand->setName(filter_input(INPUT_POST, 'name'));

            $this->show('brand/create-update',[
                'brand'=>$brand,
                'errorList'=>$errorList,
                'mode'=> $mode
            ]);
        }
    }
    public function delete($brand_id)
    {
        $brand = Brand::find($brand_id);
        if (empty($brand)) {
            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }
        $brand->delete();
        global $router;
        header('Location: '.$router->generate('brand-list'));
    }
}