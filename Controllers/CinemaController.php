<?php
    namespace Controllers;

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
            $cinemaList = $this->cinemaDAO->GetAll();
            require_once(VIEWS_PATH."Cinema-list.php");
        }

        public function Add($name, $street, $number, $phone, $email){
            #$lastId = $this->cinemaDAO->lastId();
            $lastId = 0;
            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setId($lastId+1);
            $cinema->setAddress($street." ".$number);
            $cinema->setPhone($phone);
            $cinema->setEmail($email);

            $this->cinemaDAO->Add($cinema);

            $this->ShowAddView();
        }

    }

?>