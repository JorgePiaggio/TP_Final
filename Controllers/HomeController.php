<?php
    namespace Controllers;

    class HomeController
    {

        public function __construct(){
         
        }


        public function Index($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }  
        
        public function ShowLogin(){
            require_once(VIEWS_PATH."login.php");
        }
        public function Login($email,$pass){

            if($email=="admin@moviepass.com" && $pass=="admin"){
                $_SESSION["logedUser"]=$email;
                $_SESSION["pass"]=$pass;
            }else{
                header("location:Logout");
            }

             header("location:Index");
        /*Falta agregar los clientes en esta parte*/    
        }

        public function Logout(){
        
            session_destroy();
            header("location:Index");
            
        }

    }
?>