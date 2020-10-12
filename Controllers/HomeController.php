<?php
    namespace Controllers;
    use Models\Client as Client;
    use DAO\ClientDAO as ClientDAO;
    class HomeController
    {
        private $ClientDAO;

        public function __construct(){
            $this->ClientDAO = new ClientDAO(); 
        }


        public function Index($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }  
        
        public function ShowLogin(){
            require_once(VIEWS_PATH."login.php");
        }
        public function Login($email,$pass){
            $client=$this->ClientDAO->Search($email);
            if(($email=="admin@moviepass.com" && $pass=="admin") || ($client!=null && strcmp($client->getPassWord(),$pass)==0)){
                $_SESSION["logedUser"]=$email;
                $_SESSION["pass"]=$pass;
                header("location:Index");
            }else{

                header("location:Showlogin?alert=Incorrect Email or PassWord");
            }

        }

        public function Register($name,$surname,$dni,$street,$number,$phone,$email,$pass,$repass){
            $msg='';
    
            if(strlen($name)>2 && strlen($name)<15 && strlen($surname)>2 && strlen($surname)<15){
                if(strlen($dni)>=7 && strlen($dni)<10){
                    if(strcmp($pass,$repass)==0 && $this->validatePass($pass,$msg)){
                        $newUser= new Client();
                        $newUser->setName($name);
                        $newUser->setsurName($surname);
                        $newUser->setDni($dni);
                        $newUser->setAddress($street." ".$number);
                        $newUser->setPhone($phone);
                        $newUser->setEmail($email);
                        $newUser->setPassword($pass);
                        $this->ClientDAO->add($newUser);
                        $_SESSION["logedUser"]=$email;
                        $_SESSION["pass"]=$pass;
                        header("location:Index");
    
                    }else{

                        header("location:ShowRegister?alert=Invalid PassWord .$msg");   
                    }
                }else{
                    $msg='Incorrect DNI';
                    header("location:ShowRegister?alert=$msg");  
                }
    
            }else{
                $msg='Incorrect Name or Surname';
                header("location:ShowRegister?alert=$msg");
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
               $error = "The PassWord must have at least one lowercase letter";
               return false;
            }
            if (!preg_match('`[A-Z]`',$pass)){
               $error = "The key must have at least one capital letter";
               return false;
            }
            if (!preg_match('`[0-9]`',$pass)){
               $error = "The PassWord must have at least one numeric character";
               return false;
            }
            $error = "";
            return true;
         }


        public function ShowRegister(){
            require_once(VIEWS_PATH."register.php");
        }

       
    

        public function Logout(){
        
            session_destroy();
            header("location:Index");
            
        }

    }
?>