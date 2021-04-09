<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController {
    public function login(){
       
        $this->show('user/login');
    }

    public function checkLogin(){

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $errorList = [];

        if(empty($email) || empty($password)){
            $errorList[] = 'Merci de renseigner tous les champs du formulaire';
        }

        if(empty($errorList)){

            $user = AppUser::findByEmail($email);
            //si l'adresse email n'est pas reconnue $user return false

            if($user===false){

                $errorList[] = 'Email ou mot de passe incorrect, merci de résassayer';

            } else {
                // l'email est bien reconnue, on test donc le mot de passe entre celui rentré par le user et celui hashé en bdd
                if(!password_verify($password, $user->getPassword())) {
                    $errorList[] = 'Email ou mot de passe incorrect, merci de résassayer';
                } else {
                    //email/mdp ok => on lance la session
                    $_SESSION['connectedUser'] = $user->getId();
                    //on retient l'id utilisateur connecté
                    global $router;
                    header('Location: '.$router->generate('main-home'));
                }
            }
        }
        //UX : on recupere l'adresse email saisie pour la eviter à l'utilisateur de la resaisir
        $errorAppUser = new AppUser();
        $errorAppUser->setEmail(filter_input(INPUT_POST,'email'));

        $this->show('user/login',[
            'errorList'=>$errorList,
            'errorAppUser'=>$errorAppUser,
        ]);
    }
    public function logout() {
        // sur la route logout on unset la sesssion pour déconnecter le user, puis on redirige vers login
        unset($_SESSION['connectedUser']);
        global $router;
        header('Location: '.$router->generate('user-login'));
    }
    public function list(){
        $allUsers = AppUser::findAll();
        $this->show('user/list',[
            'allUsers' => $allUsers
        ]);
    }
    public function add(){
        $this->show('user/add');
    }
    public function create(){
       
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $conf_password = filter_input(INPUT_POST, 'conf_password', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $errorList = [];

        if(empty($email)) {

            $errorList[] = 'Merci de renseigner l\'email';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $errorList[] = 'Adresse email incorrecte';
        }
        if(empty($password)) {

            $errorList[] = 'Merci de renseigner le mot de passe';
        }

        if (strlen($password) < 8) {

            $errorList[] = 'Le mot de passe doit contenir au moins 8 caractères';
        }
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        
        if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            $errorList[] = 'Le mot de passe doit contenir au moins 1 numéro, 1 lettre en majuscule, 1 lettre en minuscule';
        }
        if(empty($conf_password)) {

            $errorList[] = 'Merci de renseigner la confirmation du mot de passe';
        }

        if ($password !== $conf_password) {

            $errorList[] = 'Les mot de passe ne correspondent pas';
        }

        if(empty($firstname)) {

            $errorList[] = 'Merci de renseigner le prénom de l\'utilisateur';
        }

        if(empty($lastname)) {

            $errorList[] = 'Merci de renseigner le nom de l\'utilisateur';
        }

        if(empty($role)) {

            $errorList[] = 'Merci de selectionner un rôle';
        }

        if (!in_array($role, ['admin', 'catalog-manager'])) {

            $errorList[] = 'Rôle inconnu';
        }

        if(empty($status)) {

            $errorList[] = 'Merci de selectionner un status';
        }

        if (!in_array($status, ['1', '2'])) {

            $errorList[] = 'Status inconnu';
        }

        if (empty($errorList)) {

            $newUser = new AppUser();

            $newUser->setEmail($email);
            $newUser->setPassword($password);
            $newUser->setFirstname($firstname);
            $newUser->setLastname($lastname);
            $newUser->setRole($role);
            $newUser->setStatus($status);

            // Je demande à mon model de s'enregistrer en BDD
            $saved = $newUser->save();

            if ($saved) {

                global $router;

                header('Location: '.$router->generate('user-list'));

                return;

            } else {

                $errorList[] = 'Une erreur est survenue, merci de reessayer';
            }
        }

        if (!empty($errorList)) {

            // Je créé mon utilisateur en erreur
            $errorUser = new AppUser();

            // Je lui fourni les données en provenance direct du POST (sans filtre)
            $errorUser->setEmail(filter_input(INPUT_POST, 'email'));
            $errorUser->setPassword(filter_input(INPUT_POST, 'password'));
            $errorUser->setFirstname(filter_input(INPUT_POST, 'firstname'));
            $errorUser->setLastname(filter_input(INPUT_POST, 'lastname'));
            $errorUser->setRole(filter_input(INPUT_POST, 'role'));
            $errorUser->setStatus(filter_input(INPUT_POST, 'status'));

            $this->show('user/add', [
                'errorList' => $errorList,
                'errorUser' => $errorUser
            ]);
        } 
    }
    public function delete($user_id)
    {
        $user = AppUser::find($user_id);
        if (empty($user)) {

            header('HTTP/1.0 404 Not Found');
            return $this->show('error/err404');
        }

        $user->delete();

        global $router;
        header('Location: '.$router->generate('user-list'));
    }
}