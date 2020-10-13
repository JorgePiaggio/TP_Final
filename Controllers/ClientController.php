<?php 
namespace Controllers;
if(!$_SESSION || $_SESSION["loggedUser"]=="admin@moviepass.com"){
    header("location:../Home/Index");
}

use Models\Client as Client;
use DAO\ClientDAO as ClientDAO;

class ClientController{
    private $ClientDAO;
    
    public function __construct(){
        $this->ClientDAO = new ClientDAO(); 
    }


    public function ShowProfile($msg = ""){
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
    

    public function Edit($name,$surname,$dni,$street,$number,$phone,$email,$pass,$repass){
        $msg='';

        if(strlen($name)>2 && strlen($name)<15 && strlen($surname)>2 && strlen($surname)<15){
            if(strlen($dni)>=7 && strlen($dni)<10){
                if(strcmp($pass,$repass)==0 && $this->validatePass($pass,$msg)){
                    $client=$this->ClientDAO->Search($_SESSION['loggedUser']);

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

                    header("location:ShowProfile?alert=Invalid Password$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");   
                }
            }else{
                $msg='Incorrect DNI';
                header("location:ShowProfile?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");  
            }

        }else{
            $msg='Incorrect Name or Surname';
            header("location:ShowProfile?alert=$msg&name=$name&surname=$surname&dni=$dni&street=$street&number=$number&phone=$phone&email=$email");
        }
    }


    private function validatePass($pass,&$error){

        if(strlen($pass) < 8){
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
        $error = "";
        return true;
    }





}?>