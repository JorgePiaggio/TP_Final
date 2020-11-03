<?php
    namespace DAO;

    use DAO\ICinemaDAO as ICinemaDAO;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use Models\Cinema as Cinema;
    use DAO\Connection as Connection;

    class CinemaDAO implements ICinemaDAO{
        private $connection;
        private $tableName="cinemas";

        function __construct()
        {
            
        }


        public function add($cinema){
            $sql = "INSERT INTO ".$this->tableName." (state,name,street,number,city,country,phone,email,poster) VALUES (:state,:name,:street,:number,:city,:country,:phone,:email,:poster)";

            $parameters['name']=$cinema->getName();
            $parameters['street']=$cinema->getStreet();
            $parameters['number']=$cinema->getNumber();
            $parameters['city']=$cinema->getCity();
            $parameters['country']=$cinema->getCountry();
            $parameters['email']=$cinema->getEmail();
            $parameters['phone']=$cinema->getPhone();
            $parameters['state']=$cinema->getState();
            $parameters['poster']=$cinema->getPoster();

            try{
                $this->connection=Connection::getInstance();
            }catch(\PDOException $ex){
                throw $ex;
            }

            return $this->connection->executeNonQuery($sql, $parameters);
            
        }

        public function getAll(){
            try
            {
                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query);


                if($resultSet){
                    $mapping= $this->map($resultSet);
                    if(!is_array($mapping)){
                        array_push($cinemaList,$mapping);
                    }else{
                    $cinemaList=$mapping;
                    }
                }

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
                # throw new \PDOException("testing catch on upper level");

                $cinemaList = array();

                $query = "SELECT * FROM ".$this->tableName." WHERE state=1";

                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query);
               

                if($resultSet){
                    $mapping= $this->map($resultSet);
                    if(!is_array($mapping)){
                        array_push($cinemaList,$mapping);
                    }else{
                    $cinemaList=$mapping;
                    }
                }

            }
            catch(\PDOException $ex) //PDO Exception
            {
                throw $ex;
            }
            catch(\Exception $e)    //Generic Exception
            {
                throw $e;
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
                
               if($resultSet){
                    $mapping= $this->map($resultSet);
                    if(!is_array($mapping)){
                        array_push($cinemaList,$mapping);
                    }else{
                    $cinemaList=$mapping;
                    }
                }
            
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
                #throw new \PDOException("testing catch on upper level");
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
                $query = "UPDATE ".$this->tableName." set name=:name , street=:street, number=:number, city=:city, country=:country, phone=:phone , state=:state , email=:email, poster=:poster WHERE idCinema=:idCinema";

                
                $parameters["idCinema"]=$cinema->getIdCinema();
                $parameters["state"]=$cinema->getState();
                $parameters["name"]=$cinema->getName();
                $parameters["street"]=$cinema->getStreet();
                $parameters["city"]=$cinema->getCity();
                $parameters["country"]=$cinema->getCountry();
                $parameters["number"]=$cinema->getNumber();
                $parameters["email"]=$cinema->getEmail();
                $parameters["phone"]=$cinema->getPhone();
                $parameters["poster"]=$cinema->getPoster();

                $this->connection = Connection::getInstance();

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
                
                $parameters["idCinema"]=$idCinema;
                $parameters["idMovie"]=$idMovie;
                $parameters["state"]=$state;

                $this->connection = Connection::getInstance();

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

                $this->connection = Connection::getInstance();
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

                $this->connection = Connection::getInstance();
                $parameters["idCinema"]=$idCinema;

                $resultSet = $this->connection->execute($query,$parameters);
               
                foreach ($resultSet as $row)
                {                
                    $movie=$this->searchMovieId($row["idMovie"]);
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


        protected function getMovieGenres($movie){

            $genreList= array();

            $query = "SELECT g.idGenre, g.name FROM moviesxgenres AS mxg JOIN genres AS g ON mxg.idGenre=g.idGenre WHERE mxg.idMovie=:idMovie";
            
            $parameters["idMovie"] = $movie->getTmdbId();

            $this->connection = Connection::getInstance();

            $result= $this->connection->execute($query, $parameters);
            
           
            if($result){
                $mapping= $this->mapGenre($result);
                if(!is_array($mapping)){
                    array_push($genreList,$mapping);
                }else{
                $genreList=$mapping;
                }
            }                            

            return $genreList;
        }

 

        private function searchMovieId($tmdbId){
            try
            {
                $query = "SELECT * FROM movies WHERE idMovie= :idMovie";
                $parameters["idMovie"] = $tmdbId;

                $this->connection = Connection::getInstance();

                $result = $this->connection->execute($query, $parameters);
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }

            if(!empty($result)){
                return $this->mapMovie($result);
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
                    $cinema->setCity($p["city"]);
                    $cinema->setCountry($p["country"]);
                    $cinema->setEmail($p["email"]);
                    $cinema->setPhone($p["phone"]);
                    $cinema->setPoster($p["poster"]);
                    $cinema->setBillboard($this->getBillboard($p["idCinema"]));

                return $cinema;
            },$value);

            return count($result)>1 ? $result: $result["0"];
        }


        protected function mapMovie($value){
            $value=is_array($value) ? $value: array();
            
            $result= array_map(function ($p){
                $movie=new Movie();
                $movie->setTmdbId($p["idMovie"]);
                $movie->setTitle($p["title"]);
                $movie->setOriginalTitle($p["originalTitle"]);
                $movie->setVoteAverage($p["voteAverage"]);
                $movie->setDescription($p["overview"]);
                $movie->setReleaseDate($p["releaseDate"]);
                $movie->setPopularity($p["popularity"]);
                $movie->setVideoPath($p["videoPath"]);
                $movie->setAdult($p["adult"]);
                $movie->setPoster($p["posterPath"]);
                $movie->setBackdropPath($p["backDropPath"]);
                $movie->setOriginalLanguage($p["originalLanguage"]);
                $movie->setRuntime($p["runtime"]);
                $movie->setHomepage($p["homepage"]);
                $movie->setDirector($p["director"]);
                $movie->setReview($p["review"]);
                $movie->setState($p["state"]);

                $genres=$this->getMovieGenres($movie);
                $movie->setGenres($genres);

                return $movie;
            },$value);

            if(!empty($result)){
                return count($result)>1 ? $result: $result["0"];        
            }else{
                return null;
            }

        }

        
        protected function mapGenre($value){

            $value=is_array($value) ? $value: array();

            $result= array_map(function ($f){
                $genre= new Genre();
                $genre->SetId($f['idGenre']);
                $genre->SetName($f['name']);
                return $genre;
            },$value);

            return count($result) > 1 ? $result: $result["0"];

        }

        }             

?>