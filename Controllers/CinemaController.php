<?php
    namespace Controllers;
    
    #use DAO\CinemaDAO_JSON as CinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;
    use DAO\RoomDAO as RoomDAO;
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
            $this->msg = null;
        }

        
        public function showAddView(){
            require_once(VIEWS_PATH."Cinema-add.php");
        }


        public function showListView(){
            $cinemaList = $this->cinemaDAO->getAllActive();
            $cinemaListInactive = $this->cinemaDAO->getAllInactive(); 
            require_once(VIEWS_PATH."Cinema-list.php");
        }


    /*    public function showCatalogue(){
            $cinemaList = $this->cinemaDAO->getAllActive();
            require_once(VIEWS_PATH."Select-billboard.php");
        } */


        public function showEditView(){
            require_once(VIEWS_PATH."Cinema-edit.php");
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

        public function addToBillboard($idCinema="",$movies){
            Validate::checkParameter($idCinema);
            foreach($movies as $value){
                if(!$this->cinemaDAO->searchMovie($idCinema,$value)){
                    $this->cinemaDAO->addMovie($idCinema,$value);
                }
                else{
                    $this->cinemaDAO->stateMovie($idCinema,$value,"1"); 
                }
                $this->msg="Added correctly"; 
            }
            $this->showManageBillboard($idCinema);
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
            $this->cinemaDAO->changeState($idRemove);
            $this->showListView();
        }
        

        public function searchEdit($idCinema=""){
            Validate::checkParameter($idCinema);
            $editCinema = $this->cinemaDAO->search($idCinema);
            #$this->convertAddress($editCinema->getAddress());
            
            #$this->showEditView();
            require_once(VIEWS_PATH."Cinema-edit.php");
        }
        

        /*
        public function convertAddress($address){
            $words = explode(" ", $address);
            $numberOfWords = count($words);
            
            $street = "";
            $number = $words[$numberOfWords-1];
            for($i = 0;$i<$numberOfWords-1;$i++){ 
                $street.=$words[$i]." ";
            }
        }
        */

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

                $this->cinemaDAO->update($cinemaEdit);
                $this->msg = "Cinema modified successfully";
                $this->showListView();
            }
            else{
                $this->msg = "Already exists cinema: '$name' with address: '$street $number'";
                $this->searchEdit($idCinema);
            }
            
        }
    

    }
?>