<?php
    namespace Controllers;
    if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com"){
        header("location:../Home/index");
    }
    use Models\Cinema as Cinema;
    use DAO\CinemaDAO as CinemaDAO;

    class CinemaController{
        private $cinemaDAO;
        private $msg;
    
        public function __construct(){
            $this->cinemaDAO = new CinemaDAO(); 
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

        public function add($name, $street, $number, $phone, $email, $price){
            $lastId = $this->cinemaDAO->lastId();
            $address = $street." ".$number;

            if($this->validateCinema($name, $address)){ 
                $cinema = new Cinema();
                $cinema->setName($name);
                $cinema->setId($lastId+1);
                $cinema->setAddress($address);
                $cinema->setPhone($phone);
                $cinema->setEmail($email);
                $cinema->setPrice($price);

                $this->cinemaDAO->add($cinema);
                $this->msg = "Cinema added successfully!";
                $this->showListView();
            }   
            else{
                $this->msg = "Cinema already exists!";
                $this->showAddView();
            }
                
        }

        //Valida el cine si no existe ya un cine con el mismo nombre y misma dirección
        public function validateCinema($name, $address){
            $validate = true;
            $cinemaList = $this->cinemaDAO->getAll();
            foreach($cinemaList as $cinema){
                if(($cinema->getName() == $name) && ($cinema->getAddress() == $address))
                    $validate = false;
            }
            return $validate; //Retorna true si se puede agregar el cine y false si ya existe
        }

        public function changeState($idRemove){
            $this->cinemaDAO->changeState($idRemove);
            $this->showListView();
        }
        
        public function searchEdit($idCinema){
            $editCinema = $this->cinemaDAO->search($idCinema);

            $words = explode(" ", $editCinema->getAddress());
            $numberOfWords = count($words);
            
            $street = "";
            $number = $words[$numberOfWords-1];
            for($i = 0;$i<$numberOfWords-1;$i++){ 
                $street.=$words[$i]." ";
            }
            #$this->showEditView();
            require_once(VIEWS_PATH."Cinema-edit.php");
        }

        public function edit($name, $street, $number, $phone, $email, $price, $id){
            $aux = $this->cinemaDAO->Search($id);
            $address = $street." ".$number;

            if($this->validateCinema($name, $address)){ 
               $cinemaEdit= new Cinema();
                $cinemaEdit->setState($aux->getState());
                $cinemaEdit->setName($name);
                $cinemaEdit->setAddress($address);
                $cinemaEdit->setPhone($phone);
                $cinemaEdit->setEmail($email);
                $cinemaEdit->setId($id);
                $cinemaEdit->setPrice($price);

                $this->cinemaDAO->update($cinemaEdit);
                $this->msg = "Cinema modified successfully";
                $this->showListView();
            }
            else{
                $this->msg = "Cinema already exists";
                $this->searchEdit($id);
            }
            
        }

    }
?>