<?php 

namespace Controllers;

use Models\User as User;
use DAO\UserDAO as UserDAO;
use DAO\UsersReviewsDAO as UsersReviewsDAO;

class UserController{
    private $userDAO;
    private $userReviewsDAO;
    private $user;
    private $msg;
    
    public function __construct(){
        $this->userDAO = new UserDAO(); 
        $this->userReviewsDAO = new UsersReviewsDAO(); 
        $this->user = null;
        $this->msg = null;
    }

    public function showLogin(){
        require_once(VIEWS_PATH."login.php");
    }

    public function showProfile($msg = ""){
        $this->validateSession();
        $user = $this->userDAO->search($_SESSION['loggedUser']);
        require_once(VIEWS_PATH."User-select.php");
    }

    public function showRegister(){
        require_once(VIEWS_PATH."register.php");
    }

    public function showEditView(){
        $this->validateSession();
        require_once(VIEWS_PATH."User-profile.php");
    }

    public function showSelectUser(){
        require_once(VIEWS_PATH."User-search.php");
    }

    public function showUserView($emailUser=""){
        $user = $this->userDAO->search($emailUser);
        if(!$user){
            $this->msg = "Email doesn't exist";
            $this->showSelectUser();
        }
        else{
            require_once(VIEWS_PATH."User-view.php");    
        }
        
    }
/*
    public function showChangeRole(){
        require_once(VIEWS_PATH."User-view.php");
    }
*/
    
    /* lista de reviews que envian los users en el footer */
    public function showUserReviews($idRemove = null){
        
        if($_SESSION["loggedUser"]!="admin@moviepass.com"){
            header("location:../Home/index");
        }else{
            
            if($idRemove){
                $this->userReviewsDAO->remove($idRemove);
            }
            $messageList=$this->userReviewsDAO->getAll();
            require_once(VIEWS_PATH."reviews.php");
        }
    }

    public function login($email="",$pass=""){
        $this->checkParameter($email);
        $user=$this->userDAO->search($email); //busco el usere a traves del email
        if(($email=="admin@moviepass.com" && $pass=="admin") || ($user!=null && strcmp($user->getPassWord(),$pass)==0)){ //Comparo si es el admin o un usere y coincide mail y pass
            $_SESSION["loggedUser"]=$email; 
            if(strcmp($email,"admin@moviepass.com")!=0){   
                $_SESSION["role"]=$user->getRole()->getId();
            }else{
                $_SESSION["role"]=1;
            }
            header("location:../Home/index");
        }else{
            $this->msg = "Incorrect Email or Password";
            $this->showLogin();
        }
    }

    public function logout(){     
        session_destroy();
        header("location:../Home/index");
    }
    
    public function register($name="",$surname="",$dni="",$street="",$number="",$email="",$pass="",$repass=""){
        $this->checkParameter($name);
        if(!$this->validateEmail($email)){ 
            if($this->validatePass($pass, $repass)){
                $this->user= new user();
                $this->user->setName($name);
                $this->user->setSurname($surname);
                $this->user->setDni($dni);
                $this->user->setStreet($street);
                $this->user->setNumber($number);
                $this->user->setEmail($email);
                $this->user->setPassword($pass);
                $this->userDAO->add($this->user);
                $_SESSION["loggedUser"]=$email;
                $_SESSION["role"]=$this->user->getRole()->getId();
                header("location:../Home/index");
            }
            else{
                $this->msg = "Invalid password";  
            }
        }
        else{
            $this->msg="Email: '$email' already exists";
        }
        $this->showRegister();
    }

    public function edit($name="",$surname="",$dni="",$street="",$number="",$email="",$pass="",$repass=""){
        $this->checkParameter($name);
        $this->validateSession();
        $userAux = $this->userDAO->search($email);
            
        if($this->validatePass($pass, $repass)){
            $user= new user();
            $user->setIdUser($userAux->getIdUser());
            $user->setName($name);
            $user->setSurname($surname);
            $user->setDni($dni);
            $user->setStreet($street);
            $user->setNumber($number);
            $user->setEmail($email);
            $user->setPassword($pass);
            $this->userDAO->update($user);
            $_SESSION["loggedUser"]=$email;
            $_SESSION["role"]=$user->getRole()->getId();
            $this->msg = "Profile updated";
        }
        else{
            $this->msg = "Invalid password";  
        }
        $this->showProfile();
    }

    public function validatePass($pass, $repass){
        /*if(strlen($pass) < 8){
           $this->msg = "The password must be at least 8 characters";
           return false;
        }
        if(strlen($pass) > 16){
           $this->msg = "The password cannot be longer than 16 characters";
           return false;
        }
        if (!preg_match('`[a-z]`',$pass)){
           $this->msg = "The password must have at least one lowercase letter";
           return false;
        }
        if (!preg_match('`[A-Z]`',$pass)){
           $this->msg = "The key must have at least one capital letter";
           return false;
        }
        if (!preg_match('`[0-9]`',$pass)){
           $this->msg = "The password must have at least one numeric character";
           return false;
        }
        if (strcmp($pass, $repass) == 0){     ///VERIFICAR QUE PASA SI COMPARA 2 PASS NUMERICAS
            $this->msg = "Passwords don't match";
            return false;*/

        return true;
    }

    public function validateEmail($email){    //0 Register - 1 Edit
        $users = $this->userDAO->getAll(); 
        $answer = false;
        foreach($users as $value){
            if($value->getEmail() == $email){
                $answer = true;
            }
        }
        return $answer;
    }

    public function validateSession(){
        if(!$_SESSION || $_SESSION["loggedUser"]=="admin@moviepass.com"){
            header("location:../Home/index");
        }
    }

    private function checkParameter($value=""){
        if($value==""){
            header("location:../Home/index");
        }
    }

    public function changeRole($userEmail){
        $this->userDAO->changeRole($userEmail);
        $this->msg = "Change role with exit!";  
        $this->showUserView($userEmail);
        
    }


    /* Guarda mensajes de users sobre la web en un json */    
    public function submitReview($mail=null, $message=null){
        if($message != null){
           
            //lista de insultos
            $censuradas=array('mamón', 'forro', 'hdp', 'chupachichi');
            //contar los insultos
            $partes=count($censuradas);
            
            //censura en proceso..
            for ($i=0; $i < $partes; $i++) { 
                if(strpos($message,$censuradas[$i]) !== false ){
                    $message=str_replace($censuradas[$i],'****',$message);
                }
            }          

            // guardar en JSON 
            $msgArray = array();
            $id=($this->userReviewsDAO->getLastId())+1;
            array_push($msgArray,$id);
            array_push($msgArray,$message);
            array_push($msgArray,$mail);
            $this->userReviewsDAO->add($msgArray);
        }
        header("location:../Home/index");
    }


}

?>