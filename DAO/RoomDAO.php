<?php
    namespace DAO;

    use DAO\IRoomDAO as IRoomDAO;
    use Models\Room as Room;

    class RoomDAO implements IRoomDAO{
        private $connection;
        private $tableName="rooms";


        public function add($room, $idCinema){
            $sql = "INSERT INTO ".$this->tableName." (idCinema,name,capacity,type,price) VALUES (:idCinema,:name,:capacity,:type,:price)";

            $parameters["idCinema"]=$idCinema;
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
                    $room->setIdRoom($row["idRoom"]);
                    $room->setNumber($row["number"]);
                    $room->setType($row["type"]);
                    $room->setCapacity($row["capacity"]);
                    $room->setPrice($row["price"]);

                    array_push($roomList, $room);
                }

                return $roomList;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }
    

        public function search($idRoom){
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE idRoom=:idRoom";
                $parameters["idRoom"]=$idRoom;
                $this->connection = Connection::GetInstance();

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
                $query = "UPDATE ".$this->tableName." set name=:name, capacity=:capacity , type=:type, price=:price  WHERE idRoom=:idRoom";

                $this->connection = Connection::getInstance();
                $parameters["idRoom"]=$room->getIdRoom();
                $parameters["name"]=$room->getName();
                $parameters["capacity"]=$room->getCapacity();
                $parameters["type"]=$room->getType();
                $parameters["price"]=$room->getPrice();

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
                return $room;
            },$value);
 
            return count($result)>1 ? $result: $result["0"];
        }

        
    }             

?>