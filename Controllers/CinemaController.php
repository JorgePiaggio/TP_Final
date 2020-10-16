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

        public function Add($name, $street, $number, $phone, $email,$price){
            $lastId = $this->cinemaDAO->lastId();

            $cinema = new Cinema();
            $cinema->setName($name);
            $cinema->setId($lastId+1);
            $cinema->setAddress($street." ".$number);
            $cinema->setPhone($phone);
            $cinema->setEmail($email);
            $cinema->setPrice($price);

            $this->cinemaDAO->Add($cinema);

            $this->ShowAddView();
        }

        public function ChangeState($idRemove){
            $this->cinemaDAO->ChangeState($idRemove);
            $this->ShowListView();
        }
        
        public function SearchEdit($idCinema){
            $editCinema = $this->cinemaDAO->Search($idCinema);

            $words= explode(" ",$editCinema->getAddress());
            $numberOfWords=count($words);
            
            $street="";
            $number=$words[$numberOfWords-1];
            for($i=0; $i<$numberOfWords-1;$i++){ 
                $street.=$words[$i]." ";
            }
            #$this->ShowEditView();
            require_once(VIEWS_PATH."Cinema-edit.php");
        }

        public function Edit($name, $street, $number, $phone, $email,$price, $id){
            $aux = $this->cinemaDAO->Search($id);

            $cinemaEdit= new Cinema();
            $cinemaEdit->setState($aux->getState());
            $cinemaEdit->setName($name);
            $cinemaEdit->setAddress($street." ".$number);
            $cinemaEdit->setPhone($phone);
            $cinemaEdit->setEmail($email);
            $cinemaEdit->setId($id);
            $cinemaEdit->setPrice($price);

            $this->cinemaDAO->Update($cinemaEdit);
            $this->ShowListView();
        }


    }

?>