<?php
    namespace Controllers;
    
    #use DAO\CinemaDAO_JSON as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\RoomDAO as RoomDAO;
    use DAO\ShowDAO as ShowDAO;
    use Config\Validate as Validate;

 
    #Validate::validateSession();
 
    class CinemaController{
        private $cinemaDAO;
        private $movieDAO;
        private $genreDAO;
        private $roomDAO;
        private $msg;
    
    
        public function __construct(){
            $this->cinemaDAO = new CinemaDAO(); 
            $this->movieDAO = new MovieDAO(); 
            $this->genreDAO = new GenreDAO(); 
            $this->roomDAO = new RoomDAO();
            $this->showDAO = new ShowDAO();
            $this->msg = null;
            $this->refreshBillboard();
        }

        
        public function showAddView(){
            require_once(VIEWS_PATH."Cinemas/Cinema-add.php");
        }


        public function showListView(){
            $cinemaList = $this->cinemaDAO->getAllActive();
            $cinemaListInactive = $this->cinemaDAO->getAllInactive(); 
            require_once(VIEWS_PATH."Cinemas/Cinema-list.php");
        }


    /*    public function showCatalogue(){
            $cinemaList = $this->cinemaDAO->getAllActive();
            require_once(VIEWS_PATH."Select-billboard.php");
        } */


        public function showEditView(){
            require_once(VIEWS_PATH."Cinemas/Cinema-edit.php");
        }



        public function showAllCinemas(){
            $cinemaList = $this->cinemaDAO->getAllActive();
            #var_dump($cinemaList);      
            require_once(VIEWS_PATH."Cinemas/Cinema-list-full.php");
        }
        
        public function showCinema($idCinema){
            $cinema = $this->cinemaDAO->search($idCinema);
            $movieList = $this->cinemaDAO->getBillboard($idCinema);
            $roomList = $this->roomDAO->getCinemaRooms($idCinema);      
            require_once(VIEWS_PATH."Cinemas/Cinema-view.php");
        }

        public function addToBillboard($idCinema="",$movie){
            Validate::checkParameter($idCinema);
         
                if(!$this->cinemaDAO->searchMovie($idCinema,$movie->getTmdbId())){
                    $this->cinemaDAO->addMovie($idCinema,$movie->getTmdbId());
                }
                else{
                    $this->cinemaDAO->stateMovie($idCinema,$movie->getTmdbId(),"1"); 
                }
                
            }


        public function removeToBillboard($idCinema="",$movie){
            Validate::checkParameter($idCinema);
            if($this->cinemaDAO->searchMovie($idCinema,$movie->getTmdbId())){
                $this->cinemaDAO->stateMovie($idCinema,$movie->getTmdbId(),"0"); 
            }
        }


        
        
        public function add($name="", $street="", $number="", $phone="", $email="",$poster=""){
            Validate::checkParameter($name);
            $address = $street . $number;

            if($this->validateCinema($name, $address) == null){ 
                $cinema = new Cinema();
                $cinema->setName($name);
                $cinema->setStreet($street);
                $cinema->setNumber($number);
                $cinema->setPhone($phone);
                $cinema->setEmail($email);
                if($poster){
                    $cinema->setPoster($poster);
                }else{
                    $cinema->setPoster(IMG_PATH."cinema1.jpg");
                }
                $this->cinemaDAO->add($cinema);
                
                $this->showListView();
            }   
            else{
                $this->msg = "Already exists cinema: '$name' with address: '$street $number'";
                $this->showAddView();
            }
        }


        //Valida si no existe ya un cine con el mismo nombre y misma dirección
        public function validateCinema($name, $address){
            $cinemaList = $this->cinemaDAO->getAll();
            $idFound=null;

            foreach($cinemaList as $cinema){
                $addressAux = $cinema->getStreet() . $cinema->getNumber();
                if((strcasecmp($cinema->getName(), $name) == 0) && (strcasecmp($addressAux, $address) == 0))
                    $idFound = $cinema->getIdCinema();
            }

            return $idFound; //Retorna el id del cine si ya existe
        }


        public function changeState($idRemove=""){
            Validate::checkParameter($idRemove);
            $activeShows=$this->showDAO->getAllbyCinema($idRemove);
            
            if(!$activeShows){ 
                $this->cinemaDAO->changeState($idRemove);
            }else{
                $this->msg="Error: This Cinema has no active Shows";
            }

            $this->showListView();
        }
        

        public function searchEdit($idCinema=""){
            Validate::checkParameter($idCinema);
            $editCinema = $this->cinemaDAO->search($idCinema);
            require_once(VIEWS_PATH."Cinemas/Cinema-edit.php");
        }
        

        public function edit($name="", $street="", $number="", $phone="", $email="",$poster="", $idCinema=""){
            Validate::checkParameter($name);

            $aux = $this->cinemaDAO->search($idCinema);
            $address = $street . $number;
            $validate = $this->validateCinema($name, $address);
            
            if(!$validate || $validate == $idCinema){ 
                $cinemaEdit= new Cinema();
                $cinemaEdit->setState($aux->getState());
                $cinemaEdit->setName($name);
                $cinemaEdit->setStreet($street);
                $cinemaEdit->setNumber($number);
                $cinemaEdit->setPhone($phone);
                $cinemaEdit->setEmail($email);
                $cinemaEdit->setIdCinema($idCinema);
                $cinemaEdit->setPoster($poster);

                $result=$this->cinemaDAO->update($cinemaEdit);

                if($result > 0){
                    $this->msg = "Cinema modified successfully";
                }else{
                    $this->msg = "No rows updated. Please check your values";
                }

                $this->showListView();
            }
            else{
                $this->msg = "Already exists cinema: '$name' with address: '$street $number'";
                $this->searchEdit($idCinema);
            }
            
        }

        
        private function refreshBillboard(){ // activa el estado de peliculas que esten en una funcion de la semana por cine y las pone en cartelera del cine
            $this->initializeBillboard();
            $cinemaList=$this->cinemaDAO->getAllActive();
           
            foreach($cinemaList as $cinema){
                $shows=$this->showDAO->getByCinema($cinema->getIdCinema());
                if($shows){
                    
                    foreach($shows as $show){
                        $this->addToBillboard($cinema->getIdCinema(),$show->getMovie());
                    }
                    
                }
            }
        }


        private function initializeBillboard(){ //inicializa poniendo en estado 0 las peliculas del catalago por cine
            $movies=$this->movieDAO->getAll();
            $cinemaList=$this->cinemaDAO->getAllActive();
            if($movies){
                foreach($cinemaList as $cinema){
                    foreach($movies as $movie){
                    $this->removeToBillboard($cinema->getIdCinema(),$movie);
                    }
                }
            }
        }
    

    }
?>