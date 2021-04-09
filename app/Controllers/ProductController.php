<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Type;


class ProductController extends CoreController {
    // list les categories
    public function list() {
        $allProducts = Product::findAll();
        $this->show('product/list',[
            'allProducts' => $allProducts,
        ]);
    }
    //  page ajout d'une product
    public function add(){
        $type = Type::findAll();
        $brand = Brand::findAll();
        $category = Category::findAll();
        $this->show('product/create-update',[
            'mode' => 'create',
            'brand' => $brand,
            'category' => $category,
            'type' => $type,
        ]);
    }
    public function update($product_id){
        $type = Type::findAll();
        $product = Product::find($product_id);
        $brand = Brand::findAll();
        $category = Category::findAll();
        if(empty($product)){
            //si la categorie n'existe pas, on renvoi 404
            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }
        $this->show('product/create-update', [
            'product' => $product,
            'mode' => 'update',
            'brand' => $brand,
            'category' => $category,
            'type' => $type
        ]);
    }
    public function createEdit($product_id = null) {
    
        if(is_null($product_id)){
            //mode ajout de produit
            $mode = 'create';
        }else {
            //mode modification produit
            $mode = 'update';
            // on vérifie que le produit existe
            $product = Product::find($product_id);
            if(empty($product)){
            //si la categorie n'existe pas, on renvoi 404
            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404',[
                'product' => $product,
                
            ]);
            }
        };

        // dd($_POST); en POST on a la recuperation de nos inputs
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_URL);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
        $brand_id = filter_input(INPUT_POST, 'brandid', FILTER_SANITIZE_NUMBER_INT);
        $category_id = filter_input(INPUT_POST, 'categoryid', FILTER_SANITIZE_NUMBER_INT);
        $type_id = filter_input(INPUT_POST, 'typeid', FILTER_SANITIZE_NUMBER_INT);

        $errorList = [];

        if (empty($name)) {
            $errorList[] = 'Le nom est vide';
        }
        if ($name === false) {
            $errorList[] = 'Le nom est invalide';
        }
        if (empty($description)) {
            $errorList[] = 'La description est vide';
        }
        if ($description === false) {
            $errorList[] = 'La description est invalide';
        }
        if ($picture === false) {
            $errorList[] = 'L\'URL d\'image est invalide';
        }
        if ($price === false) {
            $errorList[] = 'Le prix est invalide';
        }
        if ($status === false) {
            $errorList[] = 'Le statut est invalide';
        }
        if (empty($brand_id)) {
            $errorList[] = 'La marque est invalide';
        }
        if (empty($category_id)) {
            $errorList[] = 'La catégorie est invalide';
        }
        if (empty($type_id)) {
            $errorList[] = 'Le type est invalide';
        }
        if(empty($errorList)){

            if($mode === 'create'){
                // en creation je crée une nouvelle instance ...
                $product= new Product();
            }
            //sinon j'ai deja une instance que je modifie
            $product->setName($name);
            $product->setDescription($description);
            $product->setPicture($picture);
            $product->setPrice($price);
            $product->setStatus($status);
            $product->setBrandId($brand_id);
            $product->setCategoryId($category_id);
            $product->setTypeId($type_id);

            $queryExecuted = $product->save();

            if($queryExecuted){
                global $router;
                header('Location: '.$router->generate('product-list'));
                //logique terminée, on coupe le code
                return;
            } else {
                $errorList[]= 'La sauvegarde a échoué, merci de retenter';
            }

        }

        if(!empty($errorList)){

            //si erreur, on créer une nouvelle instance avec les données saisies par l'utilisateur, sans filtre
            $product= new Product();
            $product->setName(filter_input(INPUT_POST, 'name'));
            $product->setDescription(filter_input(INPUT_POST, 'description'));
            $product->setPicture(filter_input(INPUT_POST, 'picture'));
            $product->setPrice(filter_input(INPUT_POST, 'price'));
            $product->setStatus(filter_input(INPUT_POST, 'status'));

            $this->show('product/create-update',[
                'product'=>$product,
                'errorList'=>$errorList,
                'mode' => $mode,
            ]);
        }
    }
    public function delete($product_id)
    {
       
        $product = Product::find($product_id);
        
        if (empty($product)) {
            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }
        $product->delete();
        global $router;
        header('Location: '.$router->generate('product-list'));
    }
}