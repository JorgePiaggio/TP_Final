<?php
    namespace DAO;

    
    use DAO\ISeatDAO as ISeatDAO;
    use Models\Seat as Seat;
 
    use DAO\Connection as Connection;
  


class SeatDAO implements ISeatDAO{
        private $connection;
        

        public function add($seat,$idRoom){
            $sql = "INSERT INTO seats ( rowSeat, numberSeat, stateSeat, idRoom)
                            VALUES (:rowSeat, :numberSeat, :stateSeat, :idRoom)";
            
            $parameters['rowSeat']=$seat->getRow();
            $parameters['numberSeat']=$seat->getNumber();
            $parameters['stateSeat']=$seat->getState();
            $parameters['idRoom']=$idRoom; 
    
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }
            catch(\PDOException $ex){
                throw $ex;
            }
        }

        public function changeState($seat)
        {
          
            try
            {

                $query = "SELECT * FROM seats WHERE idSeat= :idSeat";
                $parameters["idSeat"]=$seat->getIdSeat();
                $this->connection = Connection::getInstance();

                $result = $this->connection->execute($query,$parameters);
                if(!empty($result)){
                   
                    if($seat->getState()){
                   
                    $query = "UPDATE seats set state=0 WHERE idSeat= :idSeat";

                    }else{
                    
                    $query = "UPDATE seats set state=1 WHERE idSeat= :idSeat";
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

        public function remove($idSeat){
            try{
            $query="DELETE FROM seats WHERE idSeat=:idSeat";
            $this->connection = Connection::getInstance();
            $parameters['idSeat']=$idSeat;
            $rowCant=$this->connection->executeNonQuery($query,$parameters);
            return $rowCant;
            }   
            catch(\PDOException $ex)
            {
            throw $ex;
            } 
        }


        function search($idRoom,$row,$number){
            try
            {
                $query = "SELECT * FROM seats WHERE rowSeat= :row AND numberSeat=:number AND idRoom=:idRoom";
                $parameters["idRoom"] = $idRoom;
                $parameters["row"] = $row;
                $parameters["number"] = $number;
                
    
                $this->connection = Connection::getInstance();
    
                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
    
            if(!empty($result)){
                return $this->mapSeat($result[0]);
            }else{
                return null;
            }
        }

        public function getAll(){

            try
            {
                $seatList = array();
    
                $query = "SELECT * FROM seats";
    
                $this->connection = Connection::getInstance();
    
                $result = $this->connection->execute($query);
              
                if($result){
                    foreach($result as $value){
                        $mapping = $this->mapSeat($value);  
                        array_push($seatList, $mapping);
                    }
                    return $seatList;
                }
                else{
                    return null;
                }
                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }


        }

        public function getbyRoom($idRoom){

            try
            {
                $seatList = array();
    
                $query = "SELECT * FROM seats WHERE idRoom=:idRoom";
    
                $this->connection = Connection::getInstance();
                $parameters["idRoom"]=$idRoom;
                $result = $this->connection->execute($query,$parameters);
              
                if($result){
                    foreach($result as $value){
                        $mapping = $this->mapSeat($value);  
                        array_push($seatList, $mapping);
                    }
                    return $seatList;
                }
                else{
                    return null;
                }
                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }


        }

        protected function mapSeat($value){
            $seat=new Seat();
            $seat->setIdSeat($value["idSeat"]);
            $seat->setRow($value["rowSeat"]);
            $seat->setNumber($value["numberSeat"]);
            $seat->setState($value["stateSeat"]);
    
            return $seat;
        }
        
        

    }