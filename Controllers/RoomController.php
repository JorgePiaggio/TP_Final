<?php
    
    namespace Controllers;
    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;
    use DAO\CinemaDAO as CinemaDAO;
    class RoomController
    {
        private $cinemaDAO;
        private $roomDAO;
        private $msg;
        
        public function __construct()
        {
            $this->cinemaDAO=new CinemaDAO();
            $this->roomDAO=new RoomDAO();
            $this->msg=null;
        }
        public function showAddroom()
        {
            $cinemaList=$this->cinemaDAO->GetAll();
            require_once(VIEWS_PATH."Room-add.php");
        }  

        public function showRoomedit($idCinema,$number){
            $editRoom=$this->roomDAO->getRoom($idCinema,$number);
            require_once(VIEWS_PATH."Room-edit.php");
        }

        public function showRoomlist($idCinema){
            $roomList=$this->roomDAO->getRooms($idCinema);
            $roomsInactives=$this->roomDAO->getAllinactives($idCinema);
            require_once(VIEWS_PATH."Room-list.php");
        }


        public function add($idCine,$number,$capacity,$type,$state){
            $wanted=$this->roomDAO->getRoom($idCine,$number);
            if(!$wanted){
                $newRoom= new Room();
                $newRoom->setIdcinema($idCine);
                $newRoom->setNumber($number);
                $newRoom->setCapacity($capacity);
                $newRoom->setType($type);
                $newRoom->setState(boolval($state)); 
            
                $this->roomDAO->add($newRoom);
                $this->msg="Added correctly";
                
            }else{
                $this->msg="This Room already exists";
                 
            }
            $cinemaList=$this->cinemaDAO->GetAll();
            require_once(VIEWS_PATH."Room-add.php");
        }

        public function edit($idCinema,$capacity,$type,$state,$number){
            $room=new Room();
            $room->setIdcinema($idCinema);
            $room->setCapacity($capacity);
            $room->setType($type);
            $room->setState($state);
            $room->setnumber($number);
            $this->roomDAO->update($room);
            header("location:showSelectcinema");
        }

        public function showSelectcinema(){
        $cinemaList=$this->cinemaDAO->GetAll();
        require_once(VIEWS_PATH."Select-cinema.php");
        

        }

        public function changeState($idCinema,$number){
            $room=$this->roomDAO->getRoom($idCinema,$number);
            if($room->getState()==true){
                $room->setState(false);
            }else{
                $room->setState(true);
            }
            $this->roomDAO->update($room);
            header("location:showSelectcinema");

        }

    }

   
?>