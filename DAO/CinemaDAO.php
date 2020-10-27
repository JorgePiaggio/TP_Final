<?php
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use DAO\MovieDAO as MovieDAO;
    use Models\Cinema as Cinema;
    use DAO\Connection as Connection;

    class CinemaDAO implements ICinemaDAO{
        private $connection;
        private $tableName="cinemas";
        private $movieDAO;

        function __construct()
        {
            $this->movieDAO= new MovieDAO();
        }


        public function add($cinema){
            $sql = "INSERT INTO ".$this->tableName." (state,name,street,number,phone,email,poster) VALUES (:state,:name,:street,:number,:phone,:email,:poster)";

            $parameters['name']=$cinema->getName();
            $parameters['street']=$cinema->getStreet();
            $parameters['number']=$cinema->getNumber();
            $parameters['email']=$cinema->getEmail();
            $parameters['phone']=$cinema->getPhone();
            $parameters['state']=$cinema->getState();
            $parameters['poster']=$cinema->getPoster();

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
                
                $cinemaList=$this->map($resultSet);

                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if($resultSet){
                return $cinemaList;
            }else{
                return null;
            }
        }
        
        

        public function getAllActive(){
            try
            {
                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE state=1";

                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query);
                
                $cinemaList=$this->map($resultSet);
            

                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if($resultSet){
                return $cinemaList;
            }else{
                return null;
            }
        }
                
        

        public function getAllInactive(){
            try
            {
                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE state=0";

                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query);
                
                                
                $cinemaList=$this->map($resultSet);
            
                

                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
            if($resultSet){
                return $cinemaList;
            }else{
                return null;
            }
        }
        

        public function changeState($idCinema){
            try
            {

                $query = "SELECT * FROM ".$this->tableName." WHERE idCinema= :idCinema";
                $parameters["idCinema"]=$idCinema;
                $this->connection = Connection::getInstance();

                $result = $this->connection->execute($query,$parameters);
                if(!empty($result)){
                    $cinema=$this->map($result);
                    if($cinema->getState()){
                   
                    $query = "UPDATE ".$this->tableName." set state=0 WHERE idCinema= :idCinema";

                    }else{
                    
                    $query = "UPDATE ".$this->tableName." set state=1 WHERE idCinema= :idCinema";
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
                $query = "SELECT * FROM ".$this->tableName." WHERE idCinema= :idCinema";
                $parameters["idCinema"]=$idCinema;
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
                $query = "UPDATE ".$this->tableName." set name=:name , street=:street, number=:number , phone=:phone , state=:state , email=:email, poster=:poster WHERE idCinema=:idCinema";

                $this->connection = Connection::getInstance();
                $parameters["idCinema"]=$cinema->getIdCinema();
                $parameters["state"]=$cinema->getState();
                $parameters["name"]=$cinema->getName();
                $parameters["street"]=$cinema->getStreet();
                $parameters["number"]=$cinema->getNumber();
                $parameters["email"]=$cinema->getEmail();
                $parameters["phone"]=$cinema->getPhone();
                $parameters["poster"]=$cinema->getPoster();

                $rowCant=$this->connection->executeNonQuery($query,$parameters);
                return $rowCant;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }
        #Metodos de Cartelera
        public function stateMovie($idCinema,$idMovie,$state){
            try{
                $query = "UPDATE cinemaxmovies set state=:state WHERE idCinema=:idCinema AND idMovie=:idMovie";  
                $this->connection = Connection::getInstance();
                $parameters["idCinema"]=$idCinema;
                $parameters["idMovie"]=$idMovie;
                $parameters["state"]=$state;
                $rowCant=$this->connection->executeNonQuery($query,$parameters);
                    return $rowCant;
                }
                catch(\PDOException $ex)
                {
                    throw $ex;
                }

        }
        //Busca la pelicula dentro del cine
        public function searchMovie($idCinema,$idMovie){
            try
            {

                $query = "SELECT * FROM cinemaxmovies WHERE idCinema=:idCinema and idMovie=:idMovie";

                $this->connection = Connection::GetInstance();
                $parameters["idCinema"]=$idCinema;
                $parameters["idMovie"]=$idMovie;

                $results = $this->connection->execute($query,$parameters);
                
              
            
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
            if(!empty($results)){
                return true;
            }else{
                return false;
            }
        }
        public function addMovie($idCinema,$idMovie){
            try{
            $query = "INSERT INTO cinemaxmovies (idCinema,idMovie,state) VALUES (:idCinema,:idMovie,:state)";  
            $this->connection = Connection::getInstance();
            $parameters["idCinema"]=$idCinema;
            $parameters["idMovie"]=$idMovie;
            $parameters["state"]="1";
            $rowCant=$this->connection->executeNonQuery($query,$parameters);
                return $rowCant;
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
        }

        public function getBillboard($idCinema){
            try
            {
                $movieList = array();

                $query = "SELECT idMovie FROM cinemaxmovies WHERE idCinema=:idCinema AND state=1";

                $this->connection = Connection::GetInstance();
                $parameters["idCinema"]=$idCinema;

                $resultSet = $this->connection->execute($query,$parameters);
               
                foreach ($resultSet as $row)
                {                
                   
                    $movie=$this->movieDAO->search($row["idMovie"]);
                    
                    array_push($movieList,$movie);
            
                }
            
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
            if($resultSet){
                return $movieList;
            }else{
                return null;
            }
        }

    
       protected function map($value){
           $value=is_array($value) ? $value: array();
           
           $result= array_map(function ($p){
                $cinema=new Cinema();
                $cinema->setIdCinema($p["idCinema"]);
                $cinema->setState($p["state"]);
                $cinema->setName($p["name"]);
                $cinema->setStreet($p["street"]);
                $cinema->setNumber($p["number"]);
                $cinema->setEmail($p["email"]);
                $cinema->setPhone($p["phone"]);
                $cinema->setPoster($p["poster"]);
                $cinema->setBillboard($this->getBillboard($p["idCinema"]));

               return $cinema;
           },$value);

           return count($result)>1 ? $result: $result["0"];
       }

    }             

?>