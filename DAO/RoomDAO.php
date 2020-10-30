<?php
    namespace DAO;

    use DAO\IRoomDAO as IRoomDAO;
    use Models\Room as Room;
    use Models\Genre as Genre;
    use Models\Movie as Movie;
    use DAO\Connection as Connection;
    use Models\Cinema as Cinema;

   

    class RoomDAO implements IRoomDAO{
        private $connection;
        private $tableName="rooms";
        
        
        function __construct()
        {
            
        }
        
        public function add($room){
            $sql = "INSERT INTO ".$this->tableName." (idCinema,name_room,capacity,type,price) VALUES (:idCinema,:name,:capacity,:type,:price)";

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

                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query);
                
                            
                if($resultSet){
                    $mapping= $this->map($resultSet);
                    if(!is_array($mapping)){
                        array_push($roomList,$mapping);
                    }else{
                    $roomList=$mapping;
                    }
                }

                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
            if($resultSet){
                return $roomList;
            }else{
                return null;
            }
        }
    
        public function getCinemaRooms($idCinema){
            try
            {
                $roomList = array();
               

                $query = "SELECT * FROM ".$this->tableName." WHERE idCinema=:idCinema";
                $parameters["idCinema"]=$idCinema;
                $this->connection = Connection::getInstance();

                $resultSet = $this->connection->execute($query,$parameters);
                
                if($resultSet){
                    $mapping= $this->map($resultSet);
                    if(!is_array($mapping)){
                        array_push($roomList,$mapping);
                    }else{
                    $roomList=$mapping;
                    }
                }

                
            }
            catch(\PDOException $ex)
            {
                throw $ex;
            }
            if($resultSet){
                return $roomList;
            }else{
                return null;
            }


        }

        
        public function search($idCinema,$name){
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE idCinema=:idCinema AND name_room=:name";
               
                $this->connection = Connection::getInstance();
                $parameters["idCinema"]=$idCinema;
                $parameters["name"]=$name;

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

        public function searchById($idRoom){
            try
            {
                $query = "SELECT * FROM ".$this->tableName." WHERE idRoom=:idRoom";
                $parameters["idRoom"]=$idRoom;
                
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
                $query = "UPDATE rooms SET name_room=:name, capacity=:capacity , type=:type, price=:price  WHERE idRoom=:idRoom";

                
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
        try{
            $genreList= array();

            $query = "SELECT g.idGenre, g.name FROM moviesxgenres AS mxg JOIN genres AS g ON mxg.idGenre=g.idGenre WHERE mxg.idMovie=:idMovie";
            
            $parameters["idMovie"] = $movie->getTmdbId();

            $this->connection = Connection::getInstance();

            $resultSet= $this->connection->execute($query, $parameters);
            
            if($resultSet){
                $mapping= $this->mapGenre($resultSet);
                if(!is_array($mapping)){
                    array_push($genreList,$mapping);
                }else{
                $genreList=$mapping;
                }
            }
        }
        catch(\PDOException $ex)
        {
            throw $ex;
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

    private function searchCinema($idCinema){
        try
        {
            $query = "SELECT * FROM cinemas WHERE idCinema= :idCinema";
            $parameters["idCinema"]=$idCinema;
            $this->connection = Connection::getInstance();

            $results = $this->connection->execute($query,$parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }

        if(!empty($results)){
            return $this->mapCinema($results);
        }else{
            return null;
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
            $room->setName($p["name_room"]);
            $room->setCinema($this->searchCinema($p["idCinema"]));

            return $room;
        },$value);

        return count($result)>1 ? $result: $result["0"];
    }

    protected function mapCinema($value){
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