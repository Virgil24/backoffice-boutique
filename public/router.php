<?php 

//Main
$router->map(
    'GET',
    '/',
    [
        'controller' => 'MainController',
        'method' => 'home'
    ],
    'main-home'
);

//Cateogry
$router->map(
    'GET',
    '/categories',
    [
        'controller' => 'CategoryController',
        'method' => 'list'
    ],
    'category-list'
);
$router->map(
    'GET',
    '/category/add',
    [
        'controller' => 'CategoryController',
        'method' => 'add'
    ],
    'category-add'
);
$router->map(
    'POST',
    '/category/add',
    [
        'controller' => 'CategoryController',
        'method' => 'createEdit'
    ],
    'category-add-post'
);
$router->map(
    'GET',
    '/category/update/[i:category_id]',
    [
        'controller' => 'CategoryController',
        'method' => 'update'
    ],
    'category-update'
);
$router->map(
    'POST',
    '/category/update/[i:category_id]',
    [
        'controller' => 'CategoryController',
        'method' => 'createEdit'
    ],
    'category-update-post'

);
$router->map(
    'GET',
    '/category/delete/[i:category_id]',
    [
        'controller' => 'CategoryController',
        'method' => 'delete',
    ],
    'category-delete'
);

// products
$router->map(
    'GET',
    '/products',
    [
        'controller' => 'ProductController',
        'method' => 'list'
    ],
    'product-list'
);
$router->map(
    'GET',
    '/product/add',
    [
        'controller' => 'ProductController',
        'method' => 'add'
    ],
    'product-add'
);
$router->map(
    'POST',
    '/product/add',
    [
        'controller' => 'ProductController',
        'method' => 'createEdit'
    ],
    'product-add-post'

);
$router->map(
    'GET',
    '/product/update/[i:product_id]',
    [
        'controller' => 'ProductController',
        'method' => 'update'
    ],
    'product-update'
);
$router->map(
    'POST',
    '/product/update/[i:product_id]',
    [
        'controller' => 'ProductController',
        'method' => 'createEdit'
    ],
    'product-update-post'

);
$router->map(
    'GET',
    '/product/delete/[i:product_id]',
    [
        'controller' => 'ProductController',
        'method' => 'delete',
    ],
    'product-delete'
);
// brand
$router->map(
    'GET',
    '/brands',
    [
        'controller' => 'BrandController',
        'method' => 'list'
    ],
    'brand-list'
);
$router->map(
    'GET',
    '/brand/add',
    [
        'controller' => 'BrandController',
        'method' => 'add'
    ],
    'brand-add'
);
$router->map(
    'POST',
    '/brand/add',
    [
        'controller' => 'BrandController',
        'method' => 'createEdit'
    ],
    'brand-add-post'

);
$router->map(
    'GET',
    '/brand/update/[i:brand_id]',
    [
        'controller' => 'BrandController',
        'method' => 'update'
    ],
    'brand-update'
);
$router->map(
    'POST',
    '/brand/update/[i:product_id]',
    [
        'controller' => 'BrandController',
        'method' => 'createEdit'
    ],
    'brand-update-post'

);
$router->map(
    'GET',
    '/brand/delete/[i:brand_id]',
    [
        'controller' => 'BrandController',
        'method' => 'delete',
    ],
    'brand-delete'
);
// type
$router->map(
    'GET',
    '/types',
    [
        'controller' => 'TypeController',
        'method' => 'list'
    ],
    'type-list'
);
$router->map(
    'GET',
    '/type/add',
    [
        'controller' => 'TypeController',
        'method' => 'add'
    ],
    'type-add'
);
$router->map(
    'POST',
    '/type/add',
    [
        'controller' => 'TypeController',
        'method' => 'createEdit'
    ],
    'type-add-post'

);
$router->map(
    'GET',
    '/type/update/[i:type_id]',
    [
        'controller' => 'TypeController',
        'method' => 'update'
    ],
    'type-update'
);
$router->map(
    'POST',
    '/type/update/[i:type_id]',
    [
        'controller' => 'TypeController',
        'method' => 'createEdit'
    ],
    'type-update-post'

);
$router->map(
    'GET',
    '/type/delete/[i:type_id]',
    [
        'controller' => 'TypeController',
        'method' => 'delete',
    ],
    'type-delete'
);

//login
$router->map(
    'GET',
    '/login',
    [
        'controller' => 'UserController',
        'method' => 'login'
    ],
    'user-login'
);
$router->map(
    'POST',
    '/login',
    [
        'controller' => 'UserController',
        'method' => 'checkLogin'
    ],
    'user-login-post'

);
$router->map(
    'GET',
    '/logout',
    [
        'controller' => 'UserController',
        'method' => 'logout'
    ],
    'user-logout'
);
//users
$router->map(
    'GET',
    '/users',
    [
        'controller' => 'UserController',
        'method' => 'list'
    ],
    'user-list'
);
$router->map(
    'GET',
    '/user/add',
    [
        'controller' => 'UserController',
        'method' => 'add'
    ],
    'user-add'
);
$router->map(
    'POST',
    '/user/add',
    [
        'controller' => 'UserController',
        'method' => 'create'
    ],
    'user-add-post'

);
$router->map(
    'GET',
    '/user/delete/[i:user_id]',
    [
        'controller' => 'UserController',
        'method' => 'delete'
    ],
    'user-delete'
);
// home_order
$router->map(
    'GET',
    '/front-home',
    [
        'controller' => 'GestionController',
        'method' => 'home'
    ],
    'gestion-home'
);
$router->map(
    'POST',
    '/front-home',
    [
        'controller' => 'GestionController',
        'method' => 'homePost'
    ],
    'gestion-home-post'
);