<?php
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use Models\Cinema as Cinema;
    use DAO\Connection as Connection;

    class CinemaDAOPDO implements ICinemaDAO{
        private $connection;
        private $tableName="cinemas";


        public function add($cinema){
            $sql = "INSERT INTO ".$this->tableName." (state,name,address,phone,email) VALUES (:state,:name,:address,:phone,:email)";

            $parameters['name']=$cinema->getName();
            $parameters['address']=$cinema->getAddress();
            $parameters['email']=$cinema->getEmail();
            $parameters['phone']=$cinema->getPhone();
            $parameters['state']=$cinema->getState();

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
                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $cinema = new Cinema();
                    $cinema->setId($row["id"]);
                    $cinema->setName($row["name"]);
                    $cinema->setAddress($row["address"]);
                    $cinema->setState($row["state"]);
                    $cinema->setEmail($row["email"]);
                    $cinema->setPhone($row["phone"]);

                    array_push($cinemaList, $cinema);
                }

                return $cinemaList;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }
        
        

        public function getAllActive(){
            try
            {
                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE state=1";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $cinema = new Cinema();
                    $cinema->setId($row["id"]);
                    $cinema->setName($row["name"]);
                    $cinema->setAddress($row["address"]);
                    $cinema->setState($row["state"]);
                    $cinema->setEmail($row["email"]);
                    $cinema->setPhone($row["phone"]);

                    array_push($cinemaList, $cinema);
                }

                return $cinemaList;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }
                
        

        public function getAllInactive(){
            try
            {
                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE state=0";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $cinema = new Cinema();
                    $cinema->setId($row["id"]);
                    $cinema->setName($row["name"]);
                    $cinema->setAddress($row["address"]);
                    $cinema->setState($row["state"]);
                    $cinema->setEmail($row["email"]);
                    $cinema->setPhone($row["phone"]);

                    array_push($cinemaList, $cinema);
                }

                return $cinemaList;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }
        

        public function changeState($idCinema){
            try
            {

                $query = "SELECT * FROM ".$this->tableName." WHERE id= :id";
                $parameters["id"]=$idCinema;
                $this->connection = Connection::getInstance();

                $result = $this->connection->execute($query,$parameters);
                if(!empty($result)){
                $cinema=$this->map($result);
                    if($cinema->getState()){
                   
                    $query = "UPDATE ".$this->tableName." set state=0 WHERE id= :id";

                    }else{
                    
                    $query = "UPDATE ".$this->tableName." set state=1 WHERE id= :id";
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

        
        public function search($idCinema){
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE id= :id";
                $parameters["id"]=$idCinema;
                $this->connection = Connection::getInstance();

                $results = $this->connection->execute($query,$parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($results)){
                return $this->map($results);
            }else{
                return null;
            }
        }

        public function update($cinema){
            try
            {
               

                $query = "UPDATE ".$this->tableName." set name=:name , Address=:address , phone=:phone , state=:state , email=:email WHERE id=:id";

                $this->connection = Connection::getInstance();
                $parameters["id"]=$cinema->getId();
                $parameters["address"]=$cinema->getAddress();
                $parameters["state"]=$cinema->getState();
                $parameters["name"]=$cinema->getName();
                $parameters["email"]=$cinema->getEmail();
                $parameters["phone"]=$cinema->getPhone();

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
                $cinema=new Cinema();
                $cinema->setId($p["id"]);
                $cinema->setName($p["name"]);
                $cinema->setAddress($p["address"]);
                $cinema->setState($p["state"]);
                $cinema->setEmail($p["email"]);
                $cinema->setPhone($p["phone"]);


               return $cinema;
           },$value);

           return count($result)>1 ? $result: $result["0"];
       }

    }             

?>