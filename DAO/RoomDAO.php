<?php
    namespace DAO;

    use DAO\IRoomDAO as IRoomDAO;
    use Models\Room as Room;

    class RoomDAO implements IRoomDAO{
        private $roomList = array();


        public function add($room){
            $this->retrieveData();
            array_push($this->roomList, $room);
            $this->saveData();
        }

        public function getAll(){
            $this->retrieveData();
            return $this->roomList;
        }

        public function changeState($room){
                $index= $this->search($room->getIdCinema(),$room->getNumber());
            if($index != -1){
                $this->retrieveData();
                if($this->roomList[$index]->getState() == true){
                    $this->roomList[$index]->setState(false);
                }
                else{
                    $this->roomList[$index]->setState(true);
                }
                $this->saveData();
            }
        }

        /*
        public function Restore($idCinema){
            $wanted = $this->Search($idCinema);
            if($wanted != null){
                $this->RetrieveData();
                $this->cinemaList[($wanted->getId())-1]->setState(true);
                $this->SaveData();
            }
        }
        
        public function Remove($idCinema){
            $this->RetrieveData();
            $newList = array();
            foreach($this->cinemaList as $cinema){
                if($cinema->getId() != $idCinema){
                    array_push($newList, $cinema);
                }
            }
            $this->cinemaList = $newList;
		    $this->SaveData();
        }
        */
        
        public function search($idCinema,$number){
            $index= -1;
            $this->retrieveData();
            for( $i=0;$i<count($this->roomList);$i++){
                if($this->roomList[$i]->getNumber() == $number && $this->roomList[$i]->getIdCinema()==$idCinema){
                   $index=$i; 
                }
            }
            return $index;
        }

        public function getRoom($idCinema,$number){
            $this->retrieveData();
            for( $i=0;$i<count($this->roomList);$i++){
                if($this->roomList[$i]->getNumber() == $number && $this->roomList[$i]->getIdCinema()==$idCinema){
                   return $this->roomList[$i]; 
                }
            }
            return null;
        }

        public function getRooms($idcinema){
            $cinemaRooms=array();
            $this->retrieveData();
            foreach($this->roomList as $room){
                if($room->getIdCinema()==$idcinema && $room->getState()==true){
                    array_push($cinemaRooms,$room);
                }
            }
            return $cinemaRooms;
        }
        public function getAllInactives($idCinema){
            $inactiveRooms=array();
            $this->retrieveData();
            foreach($this->roomList as $room){
                if($room->getIdCinema()==$idCinema && $room->getState()==false){
                    array_push($inactiveRooms,$room);
                }
            }

            return $inactiveRooms;
        }
        public function update($room){
                $this->retrieveData();
                $index=$this->search($room->getIdCinema(),$room->getNumber());
                $this->roomList[$index]=$room;
                $this->saveData();
        }

        private function saveData(){
            $arrayToEncode = array();
            foreach($this->roomList as $room){
                $valuesArray["idCinema"] = $room->getIdCinema();
                $valuesArray["number"] = $room->getNumber();
                $valuesArray["capacity"] = $room->getCapacity();
                $valuesArray["type"] = $room->getType();
                $valuesArray["state"] = $room->getState();
                $valuesArray["ticketPrice"] = $room->getPrice();

                array_push($arrayToEncode, $valuesArray);
            }
            $jsonContent = json_encode($arrayToEncode , JSON_PRETTY_PRINT);
            file_put_contents('Data/rooms.json', $jsonContent);
        }

        private function retrieveData(){
            $this->roomList = array();
            
            if(file_exists('Data/rooms.json')){

                $jsonContent = file_get_contents('Data/rooms.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray){
                    $room = new Room();
                    $room->setIdcinema($valuesArray["idCinema"]);
                    $room->setState($valuesArray["state"]);
                    $room->setNumber($valuesArray["number"]);
                    $room->setType($valuesArray["type"]);
                    $room->setCapacity($valuesArray["capacity"]);
                    $room->setPrice($valuesArray["ticketPrice"]);
                    array_push($this->roomList, $room);
                }
            }
        }
    }             

?>