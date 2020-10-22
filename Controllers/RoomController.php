<?php
    namespace Controllers;

    if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com" || $_SESSION['role'] == 0){
        header("location:../Home/index");
    }

    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;
    use DAO\CinemaDAOPDO as CinemaDAOPDO;
   
    class RoomController{
        private $cinemaDAO;
        private $roomDAO;
        private $msg;
        
        public function __construct()
        {
            $this->cinemaDAO=new CinemaDAOPDO();
            $this->roomDAO=new RoomDAO();
            $this->msg=null;
        }
        
        public function showAddRoom()
        {
            $cinemaList=$this->cinemaDAO->getAllActive();
            require_once(VIEWS_PATH."Room-add.php");
        }  

        public function showRoomEdit($idCinema="",$number=""){
            $this->checkParameter($idCinema);
            $editRoom=$this->roomDAO->getRoom($idCinema,$number);
            require_once(VIEWS_PATH."Room-edit.php");
        }

        public function showRoomList($idCinema=""){
            $this->checkParameter($idCinema);
            $roomList=$this->roomDAO->getRooms($idCinema);
            $roomsInactives=$this->roomDAO->getAllInactives($idCinema);
            $cinemaSearch = $this->cinemaDAO->search($idCinema);
            require_once(VIEWS_PATH."Room-list.php");
        }

        public function showSelectCinema(){
            $cinemaList=$this->cinemaDAO->getAll();
            require_once(VIEWS_PATH."Select-cinema.php");
            }

        public function add($idCinema="",$number="",$capacity="",$type="",$state="",$price=""){
            $this->checkParameter($idCinema);
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

        public function edit($idCinema="",$idRoom="",$capacity="",$type="",$state="",$price="",$number=""){
            $this->checkParameter($idCinema);
            $room=new Room();
            $room->setIdRoom($idRoom);
            $room->setIdCinema($idCinema);
            $room->setCapacity($capacity);
            $room->setType($type);
            $room->setState($state);
            $room->setnumber($number);
            $room->setPrice($price);
            
            $this->roomDAO->update($room);

            $this->showSelectCinema();
        }

        public function changeState($idCinema="",$number=""){
            $this->checkParameter($idCinema);
            $room=$this->roomDAO->getRoom($idCinema,$number);
            
            if($room->getState()==true){
                $room->setState(false);
            }else{
                $room->setState(true);
            }
            $this->roomDAO->update($room);

            $this->showSelectCinema();
        }

        private function checkParameter($value=""){
            if($value==""){
                header("location:../Home/index");
            }
        }
    }

   

?>