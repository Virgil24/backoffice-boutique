<?php

namespace App\Controllers;
use App\Models\AppUser;

abstract class CoreController {

    public function __construct(){
        //$match contient l'info de nos routes
        global $match;
        //on recupere le nom de la route
        $routeName = $match['name'];
        //on liste nos routes
        $acl = [
            'main-home' => ['admin', 'catalog-manager'],
            'category-list'=> ['admin', 'catalog-manager'],
            'category-add'=> ['admin', 'catalog-manager'],
            'category-add-post'=> ['admin', 'catalog-manager'],
            'category-update'=> ['admin', 'catalog-manager'],
            'category-update-post'=> ['admin', 'catalog-manager'],
            'category-delete'=> ['admin'],
            'product-list'=> ['admin', 'catalog-manager'],
            'product-add'=> ['admin', 'catalog-manager'],
            'product-add-post'=> ['admin', 'catalog-manager'],
            'product-update'=> ['admin', 'catalog-manager'],
            'product-update-post'=> ['admin', 'catalog-manager'],
            'product-delete'=> ['admin'],
            'gestion-home' => ['admin', 'catalog-manager'],
            'gestion-home-post' => ['admin', 'catalog-manager'],
            'brand-list'=> ['admin', 'catalog-manager'],
            'brand-add'=> ['admin', 'catalog-manager'],
            'brand-add-post'=> ['admin', 'catalog-manager'],
            'brand-update'=> ['admin', 'catalog-manager'],
            'brand-update-post'=> ['admin', 'catalog-manager'],
            'brand-delete' => ['admin'],
            'type-list'=> ['admin', 'catalog-manager'],
            'type-add'=> ['admin', 'catalog-manager'],
            'type-add-post'=> ['admin', 'catalog-manager'],
            'type-update'=> ['admin', 'catalog-manager'],
            'type-update-post'=> ['admin', 'catalog-manager'],
            'type-delete' => ['admin', 'catalog-manager'],
            //route en libre accès pour pouvoir se connecter
            // 'user-login'=> [],
            // 'user-login-post'=> [],
            'user-logout'=> ['admin', 'catalog-manager'],
            'user-list'=> ['admin'],
            'user-add'=> ['admin'],
            'user-add-post'=> ['admin'],
            'user-delete'=> ['admin'],
        ];
        //on vérifie si la route est bine définie dans le tableau acl
        if(array_key_exists($routeName,$acl)){
            //si la route existe on recupere les roles ayant acces
            $authorizedRolesList = $acl[$routeName];
            // on effectue la verification d'autorisationd'acces avec la methode checkAuthorization
            $this->checkAuthorization($authorizedRolesList);
        }
        // on verifie le token dans le constructor pour que ce soit fait autmoatiquement
        $this->checkCSRF($routeName);
    }
    protected function show(string $viewName, $viewVars = []) {

        //on verifie si user est connecté en verifiant si la clé connecteduser est présente en session, on return true si il est connecté ou false sinon
        //on pourra verifier si user est connecté grace à $isConnected rendu disponible par extract(viewvars)
        $viewVars['isConnected'] = isset($_SESSION['connectedUser']) ? true : false;
        $viewVars['isAdmin'] = false;
        $viewVars['connectedUser'] = null;

        //on génére le token a chaque appel de la methode show et on le place dans la variable token créer grace a extract
        $_SESSION['token'] = bin2hex(random_bytes(32));
        $viewVars['token'] = $_SESSION['token'];

        // Si l'utilisateur est connecté
        if ($viewVars['isConnected']) {
            // Alors on récupère l'utilisateur connecté
            $user = AppUser::find($_SESSION['connectedUser']);
            $viewVars['connectedUser'] = $user;
            // Puis on récupère son rôle
            $viewVars['isAdmin'] = $user->getRole() == 'admin' ? true : false;
        }
        global $router;
        $viewVars['currentPage'] = $viewName; 
        // définir l'url absolue pour nos assets
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . '/assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewVars);
        require_once __DIR__.'/../views/layout/header.tpl.php';
        require_once __DIR__.'/../views/'.$viewName.'.tpl.php';
        require_once __DIR__.'/../views/layout/footer.tpl.php';
    }

    public function checkAuthorization($authorizedRoles=[]){
        //si l'utilisateur est connecté
        if(isset($_SESSION['connectedUser'])) {
            //on cherche son role, $_SESSION['connectedUser'] renvoi un id
            $user = AppUser::find($_SESSION['connectedUser']);
            $user_role = $user->getRole();
            //si le role est autorisé alors on laisse passer ...
            if(in_array($user_role, $authorizedRoles)){
                return true;
            } else {
                //sinon on renvoi une 403
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/err403');
                die();
            }
        } else {
            // si user pas connecté, on le renvoi vers login
            global $router;
            header('Location: '.$router->generate('user-login'));
        }
    }
    public function checkCSRF($routeName){
        $csrfTokenCheckInPost = [
            'category-add-post',
            'category-update-post',
            'product-add-post',
            'product-update-post',
            'brand-add-post',
            'brand-update-post',
            'type-add-post',
            'type-update-post',
            'user-add-post',
            'user-login-post',
            'gestion-home-post',
        ];
        $csrfTokenCheckInGet = [
            'category-delete',
            'product-delete',
            'user-delete',
            'type-delete',
            'brand-delete',
        ];
        // si route necessite une verification par token
        if(in_array($routeName,$csrfTokenCheckInPost)){
            //on recupere le token
            $token = isset($_POST['token']) ? $_POST['token'] : null;
            // on recupere le token en session
            $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : null;
            // importtant de verifier si les token existent sinon les deux valuers osnt a null est la verif fonctionne alors qu'il n'y a pas de token
            if(empty($token) || empty($sessionToken) || $token !== $sessionToken){
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/err403');
                die();
            }else {
                // on supprime le token en session pour la securite
                unset($_SESSION['token']);
            }
        }
        if(in_array($routeName,$csrfTokenCheckInGet)){
            //on recupere le token
            $token = isset($_GET['token']) ? $_GET['token'] : null;
            // on recupere le token en session
            $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : null;
            if(empty($token) || empty($sessionToken) || $token !== $sessionToken){
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/err403');
                die();
            }else {
                // on supprime le token en session pour la securite
                unset($_SESSION['token']);
            }
        }
    }
}
