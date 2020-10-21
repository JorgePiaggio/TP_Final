<?php 

namespace Controllers;

use Models\Client as Client;
use DAO\ClientDAO as ClientDAO;

class ClientController{
    private $clientDAO;
    private $newClient;
    private $msg;
    private $street;
    private $number;
    
    public function __construct(){
        $this->clientDAO = new ClientDAO(); 
        $this->client = null;
        $this->msg = null;
        $this->street = null;
        $this->number = null;
    }


    public function showLogin(){
        require_once(VIEWS_PATH."login.php");
    }

    public function showProfile($msg = ""){
        $this->validateSession();
        $client = $this->clientDAO->search($_SESSION['loggedUser']);

        $words = explode(" ", $client->getAddress());
        $numberOfWords = count($words);
        
        $street = "";
        $number = $words[$numberOfWords-1];
        for($i=0; $i<$numberOfWords-1;$i++){ 
            $street.=$words[$i]." ";
        }
        require_once(VIEWS_PATH."Client-profile.php");
    }

    public function showRegister(){
        require_once(VIEWS_PATH."register.php");
    }

    public function showEditView(){
        $this->validateSession();
        require_once(VIEWS_PATH."Client-profile.php");
    }

    public function login($email="",$pass=""){
        $this->checkParameter($email);
        $client=$this->clientDAO->search($email); //busco el cliente a traves del email
        if(($email=="admin@moviepass.com" && $pass=="admin") || ($client!=null && strcmp($client->getPassWord(),$pass)==0)){ //Comparo si es el admin o un cliente y coincide mail y pass
            $_SESSION["loggedUser"]=$email;    
            $_SESSION["pass"]=$pass;
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
    
    public function register($name="",$surname="",$dni="",$street="",$number="",$phone="",$email="",$pass="",$repass=""){
        $this->checkParameter($name);
        if(!$this->validateEmail($email)){ 
            if($this->validatePass($pass, $repass)){
                $this->newClient= new Client();
                $this->newClient->setName($name);
                $this->newClient->setsurName($surname);
                $this->newClient->setDni($dni);
                $this->newClient->setAddress($street." ".$number);
                $this->street = $street;
                $this->number = $number;
                $this->newClient->setPhone($phone);
                $this->newClient->setEmail($email);
                $this->newClient->setPassword($pass);
                $this->clientDAO->add($this->newClient);
                $_SESSION["loggedUser"]=$email;
                $_SESSION["pass"]=$pass;
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

    public function edit($name="",$surname="",$dni="",$street="",$number="",$phone="",$email="",$pass="",$repass=""){
        $this->checkParameter($name);
        $this->validateSession();
        $client=$this->clientDAO->search($email);
            
        if($this->validatePass($pass, $repass)){
            $newClient= new Client();
            $newClient->setId($client->getId());
            $newClient->setName($name);
            $newClient->setsurName($surname);
            $newClient->setDni($dni);
            $newClient->setAddress($street.$number);
            $newClient->setPhone($phone);
            $newClient->setEmail($email);
            $newClient->setPassword($pass);
            $this->clientDAO->update($newClient);
            $_SESSION["loggedUser"]=$email;
            $_SESSION["pass"]=$pass;
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
        $clients = $this->clientDAO->getAll(); 
        $answer = false;
        foreach($clients as $value){
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

}

?>