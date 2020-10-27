<?php
    
    namespace Controllers;
    use DAO\MovieDAO as MovieDAO;
    use DAO\CinemaDAO as CinemaDAO;

    class HomeController
    {
        private $movieDAO;

        public function __construct(){
            $this->movieDAO = new MovieDAO();
            $this->cinemaDAO = new CinemaDAO();
        }

        public function index($message = "")
        {
            $cinemaList=$this->cinemaDAO->getAllActive();
            $movieList= $this->movieDAO->getBestRated();
            $movieListSlider= $this->movieDAO->getMostPopular();
            require_once(VIEWS_PATH."home.php");
        }  

    } 

?>