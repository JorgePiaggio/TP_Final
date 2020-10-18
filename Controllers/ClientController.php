<?php 

namespace Controllers;

use Models\Client as Client;
use DAO\ClientDAO as ClientDAO;

class ClientController{
    private $clientDAO;
    
    public function __construct(){
        $this->clientDAO = new ClientDAO(); 
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

    public function login($email,$pass){
        $client=$this->clientDAO->search($email);
        if(($email=="admin@moviepass.com" && $pass=="admin") || ($client!=null && strcmp($client->getPassWord(),$pass)==0)){
            $_SESSION["loggedUser"]=$email;
            $_SESSION["pass"]=$pass;
            header("location:../Home/index");
        }else{
            header("location:showLogin?alert=Incorrect Email or Password");
        }
    }

    public function logout(){     
        session_destroy();
        header("location:../Home/Index");
    }
    
    public function register($name,$surname,$dni,$street,$number,$phone,$email,$pass,$repass){
        $msg='';
        
        if(!$this->validateEmail($email)){ 
            #if(strlen($name)>2 && strlen($name)<15 && strlen($surname)>2 && strlen($surname)<15){
                #if(strlen($dni)>=7 && strlen($dni)<10){
                    if($this->validatePass($pass, $repass, $msg)){
                        $newUser= new Client();
                        $newUser->setName($name);
                        $newUser->setsurName($surname);
                        $newUser->setDni($dni);
                        $newUser->setAddress($street." ".$number);
                        $newUser->setPhone($phone);
                        $newUser->setEmail($email);
                        $newUser->setPassword($pass);
                        $this->ClientDAO->add($newUser);
                        $_SESSION["loggedUser"]=$email;
                        $_SESSION["pass"]=$pass;
                        header("location:../Home/index");
    
                    }else{
                        header("location:showRegister?alert=Invalid Password-$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");   
                    }
                #}else{
                #    $msg='Incorrect DNI';
                #    header("location:ShowRegister?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");  
                #}
    
            #}else{
            #    $msg='Incorrect Name or Surname';
            #   header("location:ShowRegister?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");
            #}
        }else{
            $msg='email is already exist';
            header("location:ShowRegister?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");
        }
    }

    public function edit($name,$surname,$dni,$street,$number,$phone,$email,$pass,$repass){
        $this->validateSession();
        $client=$this->clientDAO->search($email);
        $msg='';

            #if(strlen($name)>2 && strlen($name)<15 && strlen($surname)>2 && strlen($surname)<15){
                #if(strlen($dni)>=7 && strlen($dni)<10){
                    if($this->validatePass($pass, $repass, $msg)){
                        $newUser= new Client();
                        $newUser->setId($client->getId());
                        $newUser->setName($name);
                        $newUser->setsurName($surname);
                        $newUser->setDni($dni);
                        $newUser->setAddress($street.$number);
                        $newUser->setPhone($phone);
                        $newUser->setEmail($email);
                        $newUser->setPassword($pass);
                        $this->clientDAO->update($newUser);
                        $_SESSION["loggedUser"]=$email;
                        $_SESSION["pass"]=$pass;
                        header("location:showProfile?alert=Profile Updated");

                    }else{
                        header("location:showProfile?alert=Invalid Password-$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");   
                    }
                #}else{
                #    $msg='Incorrect DNI';
                #    header("location:ShowProfile?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");  
                #}

            #}else{
            #    $msg='Incorrect DNI';
            #    header("location:ShowProfile?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");  
            #}
        #}else{
        #    $msg='Incorrect Name or Surname';
        #    header("location:ShowProfile?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");
        #}
    
}

    public function validatePass($pass, $repass, &$error){
        /*if(strlen($pass) < 8){
           $error = "The password must be at least 8 characters";
           return false;
        }
        if(strlen($pass) > 16){
           $error = "The password cannot be longer than 16 characters";
           return false;
        }
        if (!preg_match('`[a-z]`',$pass)){
           $error = "The password must have at least one lowercase letter";
           return false;
        }
        if (!preg_match('`[A-Z]`',$pass)){
           $error = "The key must have at least one capital letter";
           return false;
        }
        if (!preg_match('`[0-9]`',$pass)){
           $error = "The password must have at least one numeric character";
           return false;
        }
        if (strcmp($pass,$repass)==0){
            $error = "Passwords don't match";
            return false;
        }

        $error = "";*/
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

}

?>