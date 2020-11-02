<?php
    
    namespace Controllers;
    use DAO\MovieDAO as MovieDAO;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\ShowDAO as ShowDAO;
    use \DateTime;
    use \Exception as Exception;

    class HomeController
    {
        private $movieDAO;
        private $msg;
        
        public function __construct(){
            $this->movieDAO = new MovieDAO();
            $this->cinemaDAO = new CinemaDAO();
            $this->showDAO = new ShowDAO();
            $this->msg= null;
        }

        public function index($message = "")
        {

            $cinemaList=array();        /* se crean antes para evitar mostrar errores en las vistas si hay una excepcion */
            $movieList=array();
            $movieListSlider=array();
            $showList=array();
            $movieShows=array();


            try{
                $cinemaList=$this->cinemaDAO->getAllActive();
                $movieList= $this->movieDAO->getBestRated();            // 20 peliculas mejor rankeadas
                $movieListSlider= $this->movieDAO->getMostPopular();    // 5 peliculas mas populares
                
                $showList = $this->showDAO->getAllActive();
                $movieShows=array();
                
                if($showList){                                          
                    foreach($showList as $show){
                        if(!in_array($show->getMovie(), $movieShows)) {  // saco las 4 peliculas con funcion mas proxima y sus shows en dif cines
                            if(count($movieShows) <= 3){
                                array_push($movieShows,$show->getMovie());
                            }
                        }
                    }       
                }else{
                    $this->msg = "No shows on schedule";
                }
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();

            }

            require_once(VIEWS_PATH."home.php");
        }  

    } 

?>