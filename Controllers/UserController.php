<?php 

namespace Controllers;


use Models\User as User;
use DAO\UserDAO as UserDAO;
use DAO\RoleDAO as RoleDAO;
use Models\Role as Role;
use DAO\UsersReviewsDAO as UsersReviewsDAO;
use Config\Validate as Validate;
use \Exception as Exception;

class UserController{
    private $userDAO;
    private $userReviewsDAO;
    private $user;
    private $msg;
    private $roleDAO;
    
    public function __construct(){
        $this->userDAO = new UserDAO(); 
        $this->userReviewsDAO = new UsersReviewsDAO(); 
        $this->user = null;
        $this->msg = null;
        $this->roleDAO= new RoleDAO();
        $this->createRoles();
   
    }

    public function showLogin(){
        require_once(VIEWS_PATH."Users/User-login.php");
    }

    public function showProfile(){
        $user = $this->userDAO->search($_SESSION['loggedUser']);
        require_once(VIEWS_PATH."Users/User-profile.php");
    }

    public function showRegister(){
        require_once(VIEWS_PATH."Users/User-register.php");
    }

    public function showEditView(){
        require_once(VIEWS_PATH."Users/User-profile.php");
    }

    public function showSelectUser(){
        Validate::validateSession();

        require_once(VIEWS_PATH."Users/User-search.php");
    }

    public function showUserView($emailUser=""){
        Validate::validateSession();

        try{
            $user = $this->userDAO->search($emailUser);
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        if(!$user){
            $this->msg = "Email doesn't exist";
            $this->showSelectUser();
        }
        else{
            require_once(VIEWS_PATH."Users/User-view.php");    
        }
        
    }
    

    /* lista de reviews que envian los users en el footer */
    public function showUserReviews($idRemove = ""){
        Validate::validateSession();

        try{
            if($idRemove){
                $this->userReviewsDAO->remove($idRemove);
            }

            $messageList=$this->userReviewsDAO->getAll();

        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        require_once(VIEWS_PATH."Users/User-reviews.php");
    }


    public function login($email="",$pass=""){
        #Validate::checkParameter($email);

        try{
            $user=$this->userDAO->search($email); //busco el user a traves del email
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
        
        if(($email=="admin@moviepass.com" && $pass=="admin") || ($user!=null && strcmp($user->getPassWord(),$pass)==0)){ //Comparo si es el admin o un user y si coincide mail y pass
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
        Validate::checkParameter($name);

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
                try{
                    $this->userDAO->add($this->user);
                }catch(\Exception $e){
                    echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
                }
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
        Validate::checkParameter($name);
        Validate::validateSession();
        try{
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
                $result = $this->userDAO->update($user);
                
                if($result > 0) {
                    $_SESSION["loggedUser"]=$email;
                    $_SESSION["role"]=$user->getRole()->getId();
                    $this->msg = "Profile updated";
                }else{
                    $this->msg = "Internal error. Please try again later";
                }
            }
            else{
                $this->msg = "Invalid password";  
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
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
        if (strcmp($pass, $repass) == 0){     
            $this->msg = "Passwords don't match";
            return false;*/

        return true;
    }


    public function validateEmail($email=""){
        Validate::checkParameter($email);
        try{
            $users = $this->userDAO->getAll(); 
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        $answer = false;
        if($users){
        if(is_array($users)){
        foreach($users as $value){
            if($value->getEmail() == $email){
                $answer = true;
            }
        }
        }else{
            if($users->getEmail() == $email){
                $answer = true;
            }
        }

    }
        return $answer;
    }


    public function changeRole($userEmail){
        Validate::validateSession();
        
        try{
            $result = $this->userDAO->changeRole($userEmail);
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }

        if($result > 0){
            $this->msg = "Role changed succesfully!";
        }else{
            $this->msg = "Internal error. Please try again later";
        } 
        
        $this->showUserView($userEmail);
    }


    /* Guarda mensajes de users sobre la web en un json */    
    public function submitReview($mail=null, $message=null){
        Validate::validateSession();

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

            try{
                // guardar en JSON 
                $msgArray = array();
                $id=($this->userReviewsDAO->getLastId())+1;
                array_push($msgArray,$id);
                array_push($msgArray,$message);
                array_push($msgArray,$mail);
                $this->userReviewsDAO->add($msgArray);
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
        }
        header("location:../Home/index");
    }

    private function createRoles(){
        try{
            if($this->roleDAO->getAll()==null){
                $roleUser=new Role();
                $roleAdmin= new Role();
                $roleAdmin->setId(1);
                $this->roleDAO->add($roleUser);
                $this->roleDAO->add($roleAdmin);
            }
        }catch(\Exception $e){
            echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
        }
    }

}

?>