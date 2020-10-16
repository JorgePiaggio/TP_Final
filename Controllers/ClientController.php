<?php 

namespace Controllers;

use Models\Client as Client;
use DAO\ClientDAO as ClientDAO;

class ClientController{
    private $ClientDAO;
    
    public function __construct(){
        $this->ClientDAO = new ClientDAO(); 
    }


    public function ShowLogin(){
        require_once(VIEWS_PATH."login.php");
    }

    public function ShowProfile($msg = ""){
        $this->validateSession();
        $client=$this->ClientDAO->Search($_SESSION['loggedUser']);

        $words= explode(" ",$client->getAddress());
        $numberOfWords=count($words);
        
        $street="";
        $number=$words[$numberOfWords-1];
        for($i=0; $i<$numberOfWords-1;$i++){ 
            $street.=$words[$i]." ";
        }
        require_once(VIEWS_PATH."Client-profile.php");
    }

    public function ShowRegister(){
        require_once(VIEWS_PATH."register.php");
    }

    public function ShowEditView(){
        $this->validateSession();
        require_once(VIEWS_PATH."Client-profile.php");
    }

    public function Login($email,$pass){
        $client=$this->ClientDAO->Search($email);
        if(($email=="admin@moviepass.com" && $pass=="admin") || ($client!=null && strcmp($client->getPassWord(),$pass)==0)){
            $_SESSION["loggedUser"]=$email;
            $_SESSION["pass"]=$pass;
            header("location:../Home/Index");
        }else{
            header("location:ShowLogin?alert=Incorrect Email or Password");
        }
    }

    public function Logout(){     
        session_destroy();
        header("location:../Home/Index");
    }
    
    public function Register($name,$surname,$dni,$street,$number,$phone,$email,$pass,$repass){
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
                        header("location:../Home/Index");
    
                    }else{
                        header("location:ShowRegister?alert=Invalid Password-$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");   
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
            $msg='Email is already exist';
            header("location:ShowRegister?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");
        }
    }

    public function Edit($name,$surname,$dni,$street,$number,$phone,$email,$pass,$repass){
        $this->validateSession();
<<<<<<< HEAD
        $client=$this->ClientDAO->Search($email);
        $msg='';
        if(!$this->validateEmail($email)){ 
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
                        $this->ClientDAO->Update($newUser);
                        $_SESSION["loggedUser"]=$email;
                        $_SESSION["pass"]=$pass;
                        header("location:ShowProfile?alert=Profile Updated");

                    }else{
                        header("location:ShowProfile?alert=Invalid Password-$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");   
                    }
                #}else{
                #    $msg='Incorrect DNI';
                #    header("location:ShowProfile?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");  
                #}

=======
        $client=$this->ClientDAO->Search($email); //Como el email queda fijo se busca el cliente anterior para identificar su id
        $msg='';
        #if(strlen($name)>2 && strlen($name)<15 && strlen($surname)>2 && strlen($surname)<15){
            #if(strlen($dni)>=7 && strlen($dni)<10){
                if($this->validatePass($pass, $repass, $msg)){
                    $newUser= new Client();
                    $newUser->setId($client->getId());  //Se setea el id buscado anteriormente, para que el nuevo cliente(mofidicado) tenga el mismo id que el anterior
                    $newUser->setName($name); 
                    $newUser->setsurName($surname);
                    $newUser->setDni($dni);
                    $newUser->setAddress($street . " " . $number);
                    $newUser->setPhone($phone);
                    $newUser->setEmail($email);
                    $newUser->setPassword($pass);
                    $this->ClientDAO->Update($newUser);

                    $_SESSION["pass"]=$pass; //Se vuelve a igualar la session por si se modificó la contraseña
                    header("location:ShowProfile?alert=Profile Updated");

                }else{
                    header("location:ShowProfile?alert=Invalid Password-$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");   
                }
>>>>>>> 722b912f42f10c3f6169d9824dd42a2e016c2f54
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
        $clients = $this->ClientDAO->GetAll(); 
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
            header("location:../Home/Index");
        }
    }

}

?>