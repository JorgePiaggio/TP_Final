<?php
    
    namespace Controllers;
    
    class HomeController
    {
        public function index($message = "")
        {
            require_once(VIEWS_PATH."home.php");
        }  

    }
?>