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
                $_SESSION["loggedUser"]=$email;
                $_SESSION["pass"]=$pass;
                header("location:Index");
            }else{

                header("location:Showlogin?alert=Incorrect Email or Password");
            }

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
                            header("location:Index");
        
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

         private function validatePass($pass, $repass, &$error){
            /*if(strlen($pass) < 8){
               $error = "The password must be at least 8 characters";
               return false;
            }
            if(strlen($pass) > 16){
               $error = "The password cannot be longer than 16 characters";
               return false;
            }
            if (!preg_match('`[a-z]`',$pass)){
               $error = "The Password must have at least one lowercase letter";
               return false;
            }
            if (!preg_match('`[A-Z]`',$pass)){
               $error = "The key must have at least one capital letter";
               return false;
            }
            if (!preg_match('`[0-9]`',$pass)){
               $error = "The Password must have at least one numeric character";
               return false;
            }
            if (strcmp($pass,$repass)==0){
                $error = "Passwords don't match";
                return false;
            }
            
            $error = "";*/
            return true;
        }

        public function validateEmail($email){
            $answer = false;
            $clients = $this->ClientDAO->GetAll();
            foreach($clients as $value){
                if($value->getEmail() == $email){
                    $answer = true;
                } 
            }
            return $answer;
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