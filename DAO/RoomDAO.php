<?php
    namespace DAO;

    use DAO\IRoomDAO as IRoomDAO;
    use Models\Room as Room;

    class RoomDAO implements IRoomDAO{
        private $connection;
        private $tableName="rooms";


        public function add($room){
            $sql = "INSERT INTO ".$this->tableName." (idCinema,number,capacity,type,state,price) VALUES (:idCinema,:number,:capacity,:type,:state,:price)";

           $parameters["idCinema"]=$room->getIdCinema();
           $parameters["number"]=$room->getNumber();
           $parameters["type"]=$room->getType();
           $parameters["capacity"]=$room->getCapacity();
           $parameters["state"]=$room->getState();
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
                    $room->setIdCinema($row["idCinema"]);
                    $room->setNumber($row["number"]);
                    $room->setState($row["state"]);
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

        public function changeState($room){
            try
            {

                $query = "SELECT * FROM ".$this->tableName." WHERE idRoom= :idRoom";
                $parameters["idRoom"]=$room->getIdRoom();
                $this->connection = Connection::getInstance();

                $result = $this->connection->execute($query,$parameters);
                if(!empty($result)){
                $aux=$this->map($result);
                    if($aux->getState()){
                   
                    $query = "UPDATE ".$this->tableName." set state=0 WHERE idRoom= :idRoom";

                    }else{
                    
                    $query = "UPDATE ".$this->tableName." set state=1 WHERE idRoom= :idRoom";
                    }

                $rowCant=$this->connection->executeNonQuery($query,$parameters);
            }
                return $rowCant;
                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            } 
        }
    

        public function getRoom($idCinema,$number){
            try
            {

                $query = "SELECT * FROM ".$this->tableName." WHERE idCinema=:idCinema and number=:number";
                $parameters["idCinema"]=$idCinema;
                $parameters["number"]=$number;
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

        public function getRooms($idCinema){
            try
            {
                $roomList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE state=1 and idCinema=:idCinema";
                $parameters["idCinema"]=$idCinema;
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->execute($query,$parameters);
                
                foreach ($resultSet as $row)
                {                
                    $room = new Room();
                    $room->setIdRoom($row["idRoom"]);
                    $room->setIdCinema($row["idCinema"]);
                    $room->setNumber($row["number"]);
                    $room->setState($row["state"]);
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
        public function getAllInactives($idCinema){
            try
            {
                $roomList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE state=0 and idCinema=:idCinema";
                $parameters["idCinema"]=$idCinema;
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->execute($query,$parameters);
                
                foreach ($resultSet as $row)
                {                
                    $room = new Room();
                    $room->setIdRoom($row["idRoom"]);
                    $room->setIdCinema($row["idCinema"]);
                    $room->setNumber($row["number"]);
                    $room->setState($row["state"]);
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
        public function update($room){
            try
            {
               

                $query = "UPDATE ".$this->tableName." set capacity=:capacity , type=:type ,state=:state, price=:price  WHERE idRoom=:idRoom";

                $this->connection = Connection::getInstance();
                $parameters["idRoom"]=$room->getIdRoom();
                $parameters["capacity"]=$room->getCapacity();
                $parameters["state"]=$room->getState();
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
                $room->setIdCinema($p["idCinema"]);
                $room->setType($p["type"]);
                $room->setCapacity($p["capacity"]);
                $room->setPrice($p["price"]);
                $room->setNumber($p["number"]);
                $room->setState($p["state"]);
                return $room;
            },$value);
 
            return count($result)>1 ? $result: $result["0"];
        }

        
    }             

?>