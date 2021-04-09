<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;


class MainController extends CoreController {

    
    public function home()
    {
        $listCategories = Category::findAllHomePage(); 
        $listProducts = Product::findLastFive(); 

        $this->show('main/home',[
            'listCategories' => $listCategories,
            'listProducts' => $listProducts
        ]);
    }
}
