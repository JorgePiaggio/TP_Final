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

        

        public function ShowAddView(){
           
            require_once(VIEWS_PATH."Cinema-add.php");
            
        }

        public function ShowListView(){
           
            $cinemaList = $this->cinemaDAO->GetAllActive();
            $cinemaListInactive = $this->cinemaDAO->GetAllInactive(); 
            require_once(VIEWS_PATH."Cinema-list.php");
            
        }

        public function ShowEditView(){
            
            require_once(VIEWS_PATH."Cinema-edit.php");
        }

        public function Add($name, $street, $number, $phone, $email){
            $lastId = $this->cinemaDAO->lastId();

            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setId($lastId+1);
            $cinema->setAddress($street." ".$number);
            $cinema->setPhone($phone);
            $cinema->setEmail($email);

            $this->cinemaDAO->Add($cinema);

            $this->ShowAddView();
        }

        public function ChangeState($idRemove){
            $this->cinemaDAO->ChangeState($idRemove);
            $this->ShowListView();
        }
        
        public function SearchEdit($idCinema){
            $editCinema = $this->cinemaDAO->Search($idCinema);

            $address= array();
            $address= explode(" ",$editCinema->getAddress());

            #$this->ShowEditView();
            require_once(VIEWS_PATH."Cinema-edit.php");
        }

        public function Edit($name, $street, $number, $phone, $email, $id){
            $aux = $this->cinemaDAO->Search($id);

            $cinemaEdit= new Cinema();
            $cinemaEdit->setState($aux->getState());
            $cinemaEdit->setName($name);
            $cinemaEdit->setAddress($street." ".$number);
            $cinemaEdit->setPhone($phone);
            $cinemaEdit->setEmail($email);
            $cinemaEdit->setId($id);

            $this->cinemaDAO->Update($cinemaEdit);
            $this->ShowListView();
        }


    }

?>