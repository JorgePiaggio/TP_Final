<?php
    namespace Controllers;

    if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com"){
        header("location:../Home/index");
    }
    
    use Models\Cinema as Cinema;
    use DAO\CinemaDAO as CinemaDAO;
    use DAO\cinemaDAOPDO as cinemaDAOPDO;
 

    class CinemaController{
        private $cinemaDAO;
        private $msg;
    
    
        public function __construct(){
            #$this->cinemaDAO = new CinemaDAO(); 
            $this->cinemaDAO = new cinemaDAOPDO(); 
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
        
        public function showEditView(){
            require_once(VIEWS_PATH."Cinema-edit.php");
        }

        public function add($name, $street, $number, $phone, $email){
            $this->checkParameter($name);
            #$lastId = $this->cinemaDAO->lastId();
            $address = $street . $number;

            if($this->validateCinema($name, $address)){ 
                $cinema = new Cinema();
                $cinema->setName($name);
                #$cinema->setIdCinema($lastId+1);
                $cinema->setStreet($street);
                $cinema->setNumber($number);
                $cinema->setPhone($phone);
                $cinema->setEmail($email);
                $this->cinemaDAO->add($cinema);
                
                $this->showListView();
            }   
            else{
                $this->msg = "Already exists cinema: '$name' with address: '$address'.";
                $this->showAddView();
                
            }
               
            
        }

        //Valida si no existe ya un cine con el mismo nombre y misma dirección
        public function validateCinema($name, $address){
            $validate = true;
            $cinemaList = $this->cinemaDAO->getAll();
            
            foreach($cinemaList as $cinema){
                $addressAux = $cinema->getStreet() . $cinema->getNumber();
                if((strcasecmp($cinema->getName(), $name) == 0) && (strcasecmp($addressAux, $address) == 0))
                    $validate = false;
            }
            return $validate; //Retorna true si se puede agregar el cine y false si ya existe
        }

        public function changeState($idRemove=""){
            $this->checkParameter($idRemove);
            $this->cinemaDAO->changeState($idRemove);
            
            $this->showListView();
        }
        
        public function searchEdit($idCinema=""){
            $this->checkParameter($idCinema);
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

        public function edit($name="", $street="", $number="", $phone="", $email="", $idCinema=""){
            $this->checkParameter($name);
            $aux = $this->cinemaDAO->search($idCinema);
            $address = $street . $number;

            if($this->validateCinema($name, $address)){ 
               $cinemaEdit= new Cinema();
                $cinemaEdit->setState($aux->getState());
                $cinemaEdit->setName($name);
                $cinemaEdit->setStreet($street);
                $cinemaEdit->setNumber($number);
                $cinemaEdit->setPhone($phone);
                $cinemaEdit->setEmail($email);
                $cinemaEdit->setIdCinema($idCinema);

                $this->cinemaDAO->update($cinemaEdit);
                $this->msg = "Cinema modified successfully";
                $this->showListView();
            }
            else{
                $this->msg = "Already exists cinema: '$name' with address: '$address'.";
                $this->searchEdit($idCinema);
            }
            
        }

        private function checkParameter($value=""){
            if($value==""){
                header("location:../Home/index");
                return false;
            }

            return true;
        }

    

    }
?>