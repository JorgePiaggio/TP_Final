<?php
    
    namespace Controllers;
    use DAO\MovieDAO as MovieDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\ShowDAO as ShowDAO;

    class HomeController
    {
        private $movieDAO;

        public function __construct(){
            $this->movieDAO = new MovieDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->showDAO = new ShowDAO();

        }

        public function index($message = "")
        {
            $cinemaList=$this->cinemaDAO->getAllActive();
            $movieList= $this->movieDAO->getBestRated();            // 20 peliculas mejor rankeadas
            $movieListSlider= $this->movieDAO->getMostPopular();    // 5 peliculas mas populares
            $cartelera=$this->showDAO->getAllActive();               // shows proximos
            $billboard=array();
            foreach($cartelera as $show){     
                if(!in_array($show->getMovie(), $billboard)) {                      
                    array_push($billboard, $show->getMovie());
                }
            }
            require_once(VIEWS_PATH."home.php");
        }  

    } 

?>