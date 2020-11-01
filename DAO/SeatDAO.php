<?php
    namespace DAO;

    
    use DAO\ISeatDAO as ISeatDAO;
    use Models\Seat as Seat;
 
    use DAO\Connection as Connection;
  


class SeatDAO implements ISeatDAO{
        private $connection;
        

        public function add($seat, $idShow){
            $sql = "INSERT INTO seats ( rowSeat, numberSeat, idShow)
                            VALUES (:rowSeat, :numberSeat, :idShow)";
            
            $parameters['rowSeat']=$seat->getRow();
            $parameters['numberSeat']=$seat->getNumber();
            $parameters['idShow']=$idShow;
    
            try{
                $this->connection = Connection::getInstance();
                return $this->connection->executeNonQuery($sql, $parameters);
            }
            catch(\PDOException $ex){
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


        function search($idShow,$row,$number){
            try
            {
                $query = "SELECT * FROM seats WHERE rowSeat= :row AND numberSeat=:number AND idShow=:idShow";
                $parameters["idShow"] = $idShow;
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

        public function getbyShow($idShow){

            try
            {
                $seatList = array();
    
                $query = "SELECT * FROM seats WHERE idShow=:idShow";
    
                $this->connection = Connection::getInstance();
                $parameters["idShow"]=$idShow;
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
    
            return $seat;
        }
        
        

    }