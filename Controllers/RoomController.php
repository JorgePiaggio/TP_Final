<?php
    namespace Controllers;

    if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com"){
        header("location:../Home/index");
    }

    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;
    use DAO\CinemaDAO as CinemaDAO;
   
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
            $cinemaList=$this->cinemaDAO->getAll();
            require_once(VIEWS_PATH."Room-add.php");
        }  

        public function showRoomEdit($idCinema,$number){
            $editRoom=$this->roomDAO->getRoom($idCinema,$number);
            require_once(VIEWS_PATH."Room-edit.php");
        }

        public function showRoomList($idCinema){
            $roomList=$this->roomDAO->getRooms($idCinema);
            $roomsInactives=$this->roomDAO->getAllInactives($idCinema);
            $cinemaSearch = $this->cinemaDAO->search($idCinema);
            require_once(VIEWS_PATH."Room-list.php");
        }

        public function showSelectCinema(){
            $cinemaList=$this->cinemaDAO->getAll();
            require_once(VIEWS_PATH."Select-cinema.php");
            }

        public function add($idCinema,$number,$capacity,$type,$state,$price){
            $wanted=$this->roomDAO->getRoom($idCinema,$number);
            $cinemaSearch = $this->cinemaDAO->search($idCinema);
            $cinemaList=$this->cinemaDAO->getAll();

            if(!$wanted){
                $newRoom= new Room();
                $newRoom->setIdCinema($idCinema);
                $newRoom->setNumber($number);
                $newRoom->setCapacity($capacity);
                $newRoom->setType($type);
                $newRoom->setState(boolval($state));
                $newRoom->setPrice($price); 
            
                $this->roomDAO->add($newRoom);
                
                $this->showRoomList($idCinema);
            }
            else{
                $this->msg="Room: '$number' in cinema '" . $cinemaSearch->getName() ."' already exists";
                require_once(VIEWS_PATH."Room-add.php");
            }
        }

        public function edit($idCinema,$capacity,$type,$state,$price,$number){
            $room=new Room();
            $room->setIdCinema($idCinema);
            $room->setCapacity($capacity);
            $room->setType($type);
            $room->setState($state);
            $room->setnumber($number);
            $room->setPrice($price);
            
            $this->roomDAO->update($room);

            $this->showSelectCinema();
        }

        public function changeState($idCinema,$number){
            $room=$this->roomDAO->getRoom($idCinema,$number);
            
            if($room->getState()==true){
                $room->setState(false);
            }else{
                $room->setState(true);
            }
            $this->roomDAO->update($room);

            $this->showSelectCinema();
        }
    }

?>