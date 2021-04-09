<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController {
    // list les categories
    public function list() {
        $allCategories = Category::findAll();

        $this->show('category/list',[
            'allCategories' => $allCategories
        ]);
    }

    //  page ajout d'une category
    public function add(){
        $this->show('category/create-update',[
            'mode'=>'create'
        ]);
    }

    public function update($category_id){
        
        $category = Category::find($category_id);
        if(empty($category)){
            //si la categorie n'existe pas, on renvoi 404
            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }
        $this->show('category/create-update', [
            'category' => $category,
            'mode'=> 'update',
        ]);
    }

    public function createEdit($category_id = null){
        if(is_null($category_id)){
            // mode ajout categorie
            $mode = 'create';
        } else {
            // mode mise a jour categorie
            $mode = 'update';
            $category = Category::find($category_id);
            if(empty($category)){
                //si la categorie n'existe pas, on renvoi 404
                header('HTTP/1.0 404 Not Found');
                return $this->show('error/err404');
            }
        }
    
        $name = filter_input(INPUT_POST, 'catname', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_URL);

        $errorList = [];

        // test des erreurs
        if(empty($name)) {
            $errorList[]= 'Le nom de la catégorie est vide';
        }
        if(strlen($name) < 3){
            $errorList[]= 'Le nom de la catégorie doit comporter 3 caractères minimum';
        }

        if($subtitle === false) {
            $errorList[]= 'Le sous-titre est invalide';
        }
        if($picture === false) {
            $errorList[]= 'L\'URL de l\'image est invalide';
        }

        //si pas d'erreurs ...
        if(empty($errorList)){
            if($mode === 'create'){
                //en creation, je cree une nouvelle instance
                $category = new Category();
            }
            //sinon j'ai deja une instance que je modifie

            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);

            $queryExecuted = $category->save();
            if($queryExecuted){

                global $router;
                header('Location: '.$router->generate('category-list'));
                //logique terminée, on coupe le code
                return;
            } else {
                $errorList[]= 'La sauvegarde a échoué, merci de retenter';
            }
        }
        if(!empty($errorList)){

            //si erreur, on créer une nouvelle instance avec les données saisies par l'utilisateur, sans filtre
            $category = new Category();
            $category->setName(filter_input(INPUT_POST, 'catname'));
            $category->setSubtitle(filter_input(INPUT_POST, 'subtitle'));
            $category->setPicture(filter_input(INPUT_POST, 'picture'));

            $this->show('category/create-update',[
                'category'=>$category,
                'errorList'=>$errorList,
                'mode'=> $mode
            ]);
        }
    }
    public function delete($category_id)
    {
        
        $category = Category::find($category_id);

        if (empty($category)) {

            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }

        $category->delete();
        global $router;
        header('Location: '.$router->generate('category-list'));
    }
}