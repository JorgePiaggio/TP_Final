<?php
    namespace DAO;

    use DAO\IRoomDAO as IRoomDAO;
    use Models\Room as Room;
    use DAO\Connection as Connection;
    use DAO\CinemaDAO as CinemaDAO;

   

    class RoomDAO implements IRoomDAO{
        private $connection;
        private $tableName="rooms";
        private $cinemaDAO; 
        
        function __construct()
        {
            $this->cinemaDAO=new CinemaDAO();
        }
        
        public function add($room){
            $sql = "INSERT INTO ".$this->tableName." (idCinema,name,capacity,type,price) VALUES (:idCinema,:name,:capacity,:type,:price)";

            $parameters["idCinema"]=$room->getCinema()->getIdCinema();
            $parameters["name"]=$room->getName();
            $parameters["type"]=$room->getType();
            $parameters["capacity"]=$room->getCapacity();
            $parameters["price"]=$room->getPrice();
            


            try{
                $this->connection=Connection::getInstance();
                return $this->connection->executeNonQuery($sql,$parameters);

            }catch(\PDOException $ex){
                throw $ex;
            }
        }

        public function getAll(){
            try
            {
                $roomList = array();
               

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $room = new Room();
                    $room->setIdRoom($row["r.idRoom"]);
                    $room->setName($row["r.name"]);
                    $room->setType($row["r.type"]);
                    $room->setCapacity($row["r.capacity"]);
                    $room->setPrice($row["r.price"]);
                    $room->setCinema($this->cinemaDAO->search($row["idCinema"]));
                   

                    array_push($roomList, $room);
                }

                return $roomList;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }
    
        public function getCinemaRooms($idCinema){
            try
            {
                $roomList = array();
               

                $query = "SELECT * FROM ".$this->tableName." WHERE idCinema=:idCinema";
                $parameters["idCinema"]=$idCinema;
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->execute($query,$parameters);
                
                foreach ($resultSet as $row)
                {                
                    $room = new Room();
                    $room->setIdRoom($row["idRoom"]);
                    $room->setName($row["name"]);
                    $room->setType($row["type"]);
                    $room->setCapacity($row["capacity"]);
                    $room->setPrice($row["price"]);
                    $room->setCinema($this->cinemaDAO->search($row["idCinema"]));

                    array_push($roomList, $room);
                }

                return $roomList;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }


        }

        
        public function search($idCinema,$name){
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE idCinema=:idCinema and name=:name";
                $parameters["idCinema"]=$idCinema;
                $parameters["name"]=$name;
                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query,$parameters);              
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($resultSet)){
                return $this->map($resultSet);
            }else{
                return null;
            }
        }

        
        public function update($room){
            try
            {
                $query = "UPDATE rooms SET name=:name, capacity=:capacity , type=:type, price=:price  WHERE idRoom=:idRoom";

                
                $parameters["idRoom"]=$room->getIdRoom();
                $parameters["name"]=$room->getName();
                $parameters["capacity"]=$room->getCapacity();
                $parameters["type"]=$room->getType();
                $parameters["price"]=$room->getPrice();
               # $parameters["idCinema"]=$room->getCinema()->getIdCinema();

                $this->connection = Connection::getInstance();

                $rowCant=$this->connection->executeNonQuery($query,$parameters);
                return $rowCant;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }

        protected function map($value){
            $value=is_array($value) ? $value: array();
            
            $result= array_map(function ($p){
                 $room=new Room();
                $room->setIdRoom($p["idRoom"]);
                $room->setType($p["type"]);
                $room->setCapacity($p["capacity"]);
                $room->setPrice($p["price"]);
                $room->setName($p["name"]);
                $room->setCinema($this->cinemaDAO->search($p["idCinema"]));
                return $room;
            },$value);
 
            return count($result)>1 ? $result: $result["0"];
        }

        
    }             

?>