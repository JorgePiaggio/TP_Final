<?php
    namespace Controllers;

    if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com" || $_SESSION['role'] == 0){
        header("location:../Home/index");
    }

    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;
    use DAO\CinemaDAO as CinemaDAO;
   
    //VALIDAR NOMBRE DE LA SALA EN EL MISMO CINE EN ADD Y EDIT

    class RoomController{
        private $cinemaDAO;
        private $roomDAO;
        private $msg;
        
        public function __construct()
        {
            $this->cinemaDAO=new CinemaDAO();
            $this->roomDAO=new RoomDAO();
            $this->msg=null;
        }
        
        public function showAddRoom()
        {
            $cinemaList=$this->cinemaDAO->getAllActive();
            require_once(VIEWS_PATH."Room-add.php");
        }  

        public function showRoomEdit($name="",$idCinema=""){
            $this->checkParameter($idCinema);       
            $editRoom=$this->roomDAO->search($idCinema,$name);
            require_once(VIEWS_PATH."Room-edit.php");
        }

        public function showRoomList($idCinema=""){
            $this->checkParameter($idCinema); 
            $cinemaSearch=$this->cinemaDAO->search($idCinema);
            
            $roomList=$this->roomDAO->getCinemaRooms($idCinema);
            require_once(VIEWS_PATH."Room-list.php");
        }

        public function showSelectCinema(){
            $cinemaList=$this->cinemaDAO->getAll();
            require_once(VIEWS_PATH."Select-cinema.php");
            }


        public function add($idCinema="",$name="",$capacity="",$type="",$price=""){
            $this->checkParameter($idCinema);
            $wanted=$this->roomDAO->search($idCinema,$name);    /* chequear si ya existe sala con ese id y nombre */
            $cinemaSearch = $this->cinemaDAO->search($idCinema);    /*buscar cine al q agregar la sala */

            if(!$wanted){
                $newRoom= new Room();
                $newRoom->setName($name);
                $newRoom->setCapacity($capacity);
                $newRoom->setType($type);
                $newRoom->setPrice($price);
                $newRoom->setCinema($cinemaSearch); 
            
                $this->roomDAO->add($newRoom);        //Le pasa la sala al DA0 para que la agregue a la BD
                $this->showRoomList($idCinema);
            }
            else{
                $cinemaList=$this->cinemaDAO->getAll();
                $this->msg="Room: '$name' in cinema '" . $cinemaSearch->getName() ."' already exists";
                require_once(VIEWS_PATH."Room-add.php");
            }
        }


        public function edit($idCinema="",$name="",$capacity="",$type="",$price="", $idRoom=""){
            $this->checkParameter($idRoom);
            $wanted=$this->roomDAO->search($idCinema,$name);
            $cinema=$this->cinemaDAO->search($idCinema);
            if(!$wanted || $wanted->getCinema()->getIdCinema() == $cinema->getIdCinema()){
            $room=new Room();
            $room->setIdRoom($idRoom);
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setType($type);
            $room->setPrice($price);
            $room->setCinema($cinema);
            
            $this->roomDAO->update($room);
            }else{
                $this->msg="Room: '$name' in cinema '" . $cinema->getName() ."' already exists"; 
            }
            $this->showRoomList($idCinema);
        }

       
        private function checkParameter($value=""){
            if($value==""){
                header("location:../Home/index");
            }
        }
    }

   

?>