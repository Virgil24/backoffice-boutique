<?php

namespace App\Controllers;

use App\Models\Category;

class GestionController extends CoreController {
    public function home(){
       
        $allCategories = Category::findAll();
        $this->show('gestion/home',[
            'allCategories' =>$allCategories
        ]);
    }
    public function homePost(){
        
        //on recupere tous les emplacements actuels
        $allEmplacements = $_POST['emplacement'];
        $errorList = [];

        if(count($allEmplacements) !== 5){
            $errorList[] = 'Une erreur est survenue';
            die();
        }
        //on reinitialise les choix pour ne pas avoir de doublon
        Category::resetHomeOrder();
        // index = emplacement -1 => id de la cateogrie
        foreach($allEmplacements as $index => $categoryId ) :
            $emplacementNumber = $index+1;

            // on retrouver la categorie choisie selon son id
            $targetedCategory = Category::find($categoryId);

            if(empty($targetedCategory)){
                'La catégorie n\'existe pas';
                break;
            }

            $targetedCategory->setHomeOrder($emplacementNumber);
            $targetedCategory->save();
        endforeach;

        if(empty($errorList)){
            global $router;
            header('Location: '.$router->generate('main-home'));
        }
        $allCategories = Category::findAll();
        if(!empty($errorList)){
            $this->show('gestion/home',[
                'errorList'=>$errorList,
                'allCategories' => $allCategories

            ]);
        }

    }
}