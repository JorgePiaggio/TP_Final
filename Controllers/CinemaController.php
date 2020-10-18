<?php
    namespace Controllers;
    if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com"){
        header("location:../Home/Index");
    }
    use Models\Cinema as Cinema;
    use DAO\CinemaDAO as CinemaDAO;

    class CinemaController{
        private $cinemaDAO;
    
        public function __construct(){
            $this->cinemaDAO = new CinemaDAO(); 
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

            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setId($lastId+1);
            $cinema->setAddress($street." ".$number);
            $cinema->setPhone($phone);
            $cinema->setEmail($email);
            $cinema->setPrice($price);

            $this->cinemaDAO->add($cinema);

            $this->showAddView();
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

            $cinemaEdit= new Cinema();
            $cinemaEdit->setState($aux->getState());
            $cinemaEdit->setName($name);
            $cinemaEdit->setAddress($street." ".$number);
            $cinemaEdit->setPhone($phone);
            $cinemaEdit->setEmail($email);
            $cinemaEdit->setId($id);
            $cinemaEdit->setPrice($price);

            $this->cinemaDAO->update($cinemaEdit);
            $this->showListView();
        }

    }
?>