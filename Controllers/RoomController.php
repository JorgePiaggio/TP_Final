<?php
    namespace Controllers;

    use DAO\RoomDAO as RoomDAO;
    use Models\Room as Room;
    use DAO\CinemaDAO as CinemaDAO;
    use Config\Validate as Validate;
    use \Exception as Exception;

    Validate::validateSession();
   

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
            try{
                $cinemaList=$this->cinemaDAO->getAllActive();
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
            
            require_once(VIEWS_PATH."Rooms/Room-add.php");
        }  


        public function showRoomEdit($name="",$idCinema=""){
            Validate::checkParameter($idCinema);   

            try{
                $editRoom=$this->roomDAO->search($idCinema,$name);
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
        
            require_once(VIEWS_PATH."Rooms/Room-edit.php");
        }


        public function showRoomList($idCinema=""){
            Validate::checkParameter($idCinema); 

            try{
                $cinemaSearch=$this->cinemaDAO->search($idCinema);
                $roomList=$this->roomDAO->getCinemaRooms($idCinema);
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
        
            require_once(VIEWS_PATH."Rooms/Room-list.php");
        }


        public function showSelectCinema(){
            try{
                $cinemaList=$this->cinemaDAO->getAll();
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
        
            require_once(VIEWS_PATH."Rooms/Room-select-cinema.php");
        }


        public function add($idCinema="",$name="",$rows="",$columns="",$type="",$price=""){
            Validate::checkParameter($idCinema);

            try{
                  $wanted=$this->roomDAO->search($idCinema,$name);    /* chequear si ya existe sala con ese id y nombre */
                  $cinemaSearch = $this->cinemaDAO->search($idCinema);    /*buscar cine al q agregar la sala */

                  if(!$wanted){
                      $newRoom= new Room();
                      $newRoom->setName($name);
                      $newRoom->setCapacity($rows*$columns);
                      $newRoom->setRows($rows);
                      $newRoom->setColumns($columns);
                      $newRoom->setType($type);
                      $newRoom->setPrice($price);
                      $newRoom->setCinema($cinemaSearch); 

                      $this->roomDAO->add($newRoom);        //Le pasa la sala al DA0 para que la agregue a la BD
                      $this->showRoomList($idCinema);
                  }
                  else{
                      $cinemaList=$this->cinemaDAO->getAll();
                      $this->msg="Room: '$name' in cinema '" . $cinemaSearch->getName() ."' already exists";
                      require_once(VIEWS_PATH."Rooms/Room-add.php");
                }
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
        }


        public function edit($idCinema="",$name="",$rows="",$columns="",$type="",$price="", $idRoom=""){
            Validate::checkParameter($idRoom);
            
            try{
                $wanted=$this->roomDAO->search($idCinema,$name);
                $cinema=$this->cinemaDAO->search($idCinema);
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
            
                if(!$wanted || $wanted->getIdRoom()==$idRoom){     //si no existe la sala con ese nombre, o existe en un cine diferente, se deja crear
                    $room=new Room();
                    $room->setIdRoom($idRoom);
                    $room->setName($name);
                    $room->setCapacity($rows*$columns);
                    $room->setRows($rows);
                    $room->setColumns($columns);
                    $room->setType($type);
                    $room->setPrice($price);
                    $room->setCinema($cinema);
                    try{
                        $result = $this->roomDAO->update($room);
                    }catch(\Exception $e){
                        echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
                    }

                    if($result > 0){
                        $this->msg = "Room modified successfully";
                        }else{
                            $this->msg = "No rows updated. Please check your values";
                        }
                }else{
                    $this->msg="Room: '$name' in cinema '" . $cinema->getName() ."' already exists"; 
                }
          
            $this->showRoomList($idCinema);
        }

    }

   

?>