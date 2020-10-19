<?php
    
    namespace Controllers;
    use DAO\MovieDAO as MovieDAO;

    class HomeController
    {
        private $movieDAO;

        public function __construct(){
            $this->movieDAO = new MovieDAO();
        }

        public function index($message = "")
        {
            $movieList=$this->movieDAO->getBestRated();
            require_once(VIEWS_PATH."home.php");
        }  

    }
?>