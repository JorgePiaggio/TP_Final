<?php
    namespace DAO;

    use DAO\IShowDAO as IShowDAO;
    use Models\Show as Show;
    use Models\Room as Room;
    use Models\Cinema as Cinema;
    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use DAO\Connection as Connection;
    use \DateTime;
    use \DateTimeZone;

    class ShowDAO implements IShowDAO{
        private $connection;


        function __construct(){}


    public function add($show){
        $sql = "INSERT INTO shows (idRoom, idMovie, dateTime, shift, remainingTickets)
                        VALUES (:idRoom, :idMovie, :dateTime, :shift, :remainingTickets)";
        $stringDate =$show->getDateTime()->format('Y/m/d H:i:s');
        $parameters['idRoom']=$show->getRoom()->getIdRoom();
        $parameters['idMovie']=$show->getMovie()->getTmdbID();
        $parameters['dateTime']=$stringDate;
        $parameters['shift']=$this->setShift($show->getDateTime()); //seteo el turno segun el horario de la funcion


        $parameters['remainingTickets']=$show->getRoom()->getCapacity();

        try{
            $this->connection = Connection::getInstance();
            return $this->connection->executeNonQuery($sql, $parameters);
        }
        catch(\PDOException $ex){
            throw $ex;
        }
    }  

    /* Setea el turno según el horario de la función */
    private function setShift($dateTime){

        $dateTime =$dateTime->format('H');
        
        $midday = 12;
        $afternoon = 19;            
        $night = 6;
        $midnight=24;

        if($dateTime < $midday && $dateTime >= $night ){
            return "Morning";
        }else{
            if($dateTime >= $midday && $dateTime <= $afternoon)
            {
                return "Afternoon";
            }else{
                if($dateTime > $afternoon && $dateTime < $midnight || $dateTime < $night ){
                    return "Night";
                }
            }
        }
    }



    public function search($idShow){
        try
        {   
            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE s.idShow= :idShow";
            
            $parameters["idShow"]=$idShow;
            
            $this->connection = Connection::getInstance();
            
            $result = $this->connection->execute($query,$parameters);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }

        if(!empty($result)){
            return $this->mapShow($result[0]);
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

            $result= $this->connection->execute($query, $parameters);
            
       
            if($result){
                $mapping= $this->mapGenre($result);
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

        if(!empty($result)){
            return $genreList;
        }else{
            return null;
        }
        
    }


        
    public function getAll(){
        try
        {
            $showList = array();

            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema";

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query);
          
            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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



    /* Retorna las funciones activas de la semana */
    public function getAllActive(){
        try
        {
            $showList = array();
     
            /*Fecha actual*/
            $dateNow = (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');

            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE DATEDIFF(s.dateTime, :dateTime) <= 7 AND DATEDIFF(s.dateTime, :dateTime) >= 0
            ORDER BY s.dateTime ASC";

            $parameters["dateTime"] = $dateNow;
            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query, $parameters);

            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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


    /* Retorna las funciones que ya pasaron */
    public function getAllInactive(){
        try
        {
            $showList = array();


            /*Fecha actual*/
            $dateNow = (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');


            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE s.dateTime < :dateTime";
            
            $parameters["dateTime"] = $dateNow;

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query, $parameters);
            
            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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

    /* retorna peliculas por sala por fecha */
    public function getShowbyTimebyRoom($idRoom,$date){
        $showList = array();

        try
        {       
            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE s.idRoom= :idRoom AND DATEDIFF(:dateTime, s.dateTime) <= 1";
            
            $parameters["idRoom"]=$idRoom;
            $parameters["dateTime"]=$date;

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query,$parameters);

            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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


    /* retorna peliculas por cine, max una semana */
    public function getByCinema($idCinema){   
        /*Fecha actual*/
        $dateNow = (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');
        $showList = array();

        try
        {       
            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE r.idCinema= :idCinema AND DATEDIFF(s.dateTime, :dateTime) <= 7 AND DATEDIFF(s.dateTime, :dateTime) >= 0";
            
            $parameters["idCinema"]=$idCinema;
            $parameters["dateTime"]=$dateNow;

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query,$parameters);

            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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

    //devuelve todas las funciones actuales y futuras por cine sin limite de tiempo futuro
    public function getAllByCinema($idCinema){   
        /*Fecha actual*/
        $dateNow = (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');
        $showList = array();

        try
        {       
            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE r.idCinema= :idCinema AND DATEDIFF(s.dateTime, :dateTime) >= 0";
            
            $parameters["idCinema"]=$idCinema;
            $parameters["dateTime"]=$dateNow;

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query,$parameters);

            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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


    /* retorna funciones de una pelicula en un cine, max una semana */
    public function getByCinemaByMovie($idCinema, $idMovie){   
        /*Fecha actual*/
        $dateNow = (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');
        $showList = array();

        try
        {   
            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE r.idCinema= :idCinema AND DATEDIFF(s.dateTime, :dateTime) <= 7 AND DATEDIFF(s.dateTime, :dateTime) >= 0 AND s.idMovie = :idMovie";
            
            $parameters["idCinema"]=$idCinema;
            $parameters["idMovie"]=$idMovie;
            $parameters["dateTime"]=$dateNow;

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query,$parameters);

            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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



    /* funciones de una pelicula en todos los cines max 1 semana */
    public function getByMovie($idMovie){   
        /*Fecha actual*/
        $dateNow = (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');
        $showList = array();

        try
        {   
            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE DATEDIFF(s.dateTime, :dateTime) <= 7 AND DATEDIFF(s.dateTime, :dateTime) >= 0 AND s.idMovie = :idMovie";
            
            $parameters["idMovie"]=$idMovie;
            $parameters["dateTime"]=$dateNow;

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query,$parameters);

            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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


        /* funciones de una pelicula en todos los cines sin limite de tiempo futuro */
        public function getAllByMovie($idMovie){   
            /*Fecha actual*/
            $dateNow = (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');
            $showList = array();
    
            try
            {   
                $query = "SELECT * FROM shows s 
                INNER JOIN movies m ON s.idMovie = m.idMovie 
                INNER JOIN rooms r ON s.idRoom = r.idRoom 
                INNER JOIN cinemas c ON r.idCinema = c.idCinema
                WHERE DATEDIFF(s.dateTime, :dateTime) >= 0 AND s.idMovie = :idMovie";
                
                $parameters["idMovie"]=$idMovie;
                $parameters["dateTime"]=$dateNow;
    
                $this->connection = Connection::getInstance();
    
                $result = $this->connection->execute($query,$parameters);
    
                if($result){
                    foreach($result as $value){
                        $mapping = $this->mapShow($value);  
                        array_push($showList, $mapping);
                    }
                    return $showList;
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



        /* funciones de una pelicula en cualquier cine, en un dia determinado (REQUISITO PARA REVISION 3) */
        public function getByMovieByDay($idMovie, $date){   

            $showList = array();
    
            try{   
                    $query = "SELECT * FROM shows s 
                    INNER JOIN movies m ON s.idMovie = m.idMovie 
                    INNER JOIN rooms r ON s.idRoom = r.idRoom 
                    INNER JOIN cinemas c ON r.idCinema = c.idCinema
                    WHERE DATEDIFF(s.dateTime, :dateTime) = 0 AND s.idMovie = :idMovie";
                    
                    $parameters["idMovie"]=$idMovie;
                    $parameters["dateTime"]=$date;
        
                    $this->connection = Connection::getInstance();
        
                    $result = $this->connection->execute($query,$parameters);
        
                    if($result){
                        foreach($result as $value){
                            $mapping = $this->mapShow($value);  
                            array_push($showList, $mapping);
                        }
                        return $showList;
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


    /* por pelicula por cine por turno */
    public function getByCinemaByMovieByShift($idCinema, $idMovie, $shift){   
        /*Fecha actual*/
        $dateNow = (new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires')))->format('Y-m-d H:i:s');
        $showList = array();

        try
        {   
            $query = "SELECT * FROM shows s 
            INNER JOIN movies m ON s.idMovie = m.idMovie 
            INNER JOIN rooms r ON s.idRoom = r.idRoom 
            INNER JOIN cinemas c ON r.idCinema = c.idCinema
            WHERE r.idCinema= :idCinema AND DATEDIFF(s.dateTime, :dateTime) <= 7 AND DATEDIFF(s.dateTime, :dateTime) >= 0 AND s.idMovie = :idMovie AND s.shift=:shift";
            
            $parameters["idCinema"]=$idCinema;
            $parameters["idMovie"]=$idMovie;
            $parameters["shift"]=$shift;
            $parameters["dateTime"]=$dateNow;

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query,$parameters);

            if($result){
                foreach($result as $value){
                    $mapping = $this->mapShow($value);  
                    array_push($showList, $mapping);
                }
                return $showList;
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

    
    protected function getBillboard($idCinema){
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


    public function update($show){
        try
        {   
            $query = "UPDATE shows set idRoom=:idRoom , idMovie=:idMovie, dateTime=:dateTime , shift=:shift , remainingTickets=:remainingTickets WHERE idShow=:idShow";

            $this->connection = Connection::getInstance();
            $parameters['idShow']=$show->getIdShow();

            $parameters['idRoom']=$show->getRoom()->getIdRoom();
            $parameters['idMovie']=$show->getMovie()->getTmdbID();
            $parameters['dateTime']=$show->getDateTime()->format('Y-m-d H:i:s');
            $parameters['shift']=$this->setShift($show->getDateTime());
            $parameters['remainingTickets']=$show->getRemainingTickets();

            

            $rowCant=$this->connection->executeNonQuery($query,$parameters);
            return $rowCant;
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }

    public function delete($idShow){
        try{
        $query="DELETE FROM shows WHERE idShow=:idShow";
        $this->connection = Connection::getInstance();
        $parameters['idShow']=$idShow;
        $rowCant=$this->connection->executeNonQuery($query,$parameters);
        return $rowCant;
        }   
        catch(\PDOException $ex)
        {
        throw $ex;
        } 
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
            return $this->mapMovie($result[0]);
        }else{
            return null;
        }
    }


    
    protected function mapShow($value){
        
            $show=new Show();
            $show->setIdShow($value["idShow"]);
            $show->setRoom($this->mapRoom($value));
            $show->setMovie($this->mapMovie($value));
            $show->setDateTime($value["dateTime"]);
            $show->setShift($value["shift"]);
            $show->setRemainingTickets($value["remainingTickets"]);
            
            return $show;
      
    }

    protected function mapRoom($value){
        
            $room=new Room();
            $room->setIdRoom($value["idRoom"]);
            $room->setType($value["type"]);
            $room->setCapacity($value["capacity"]);
            $room->setPrice($value["price"]);
            $room->setName($value["nameroom"]);
            $room->setCinema($this->mapCinema($value));

            return $room;

        
    }

    protected function mapCinema($value){
        
        
        
             $cinema=new Cinema();
             $cinema->setIdCinema($value["idCinema"]);
             $cinema->setState($value["state"]);
             $cinema->setName($value["name"]);
             $cinema->setStreet($value["street"]);
             $cinema->setNumber($value["number"]);
             $cinema->setEmail($value["email"]);
             $cinema->setPhone($value["phone"]);
             $cinema->setPoster($value["poster"]);
             $cinema->setBillboard($this->getBillboard($value["idCinema"]));

            return $cinema;
    }

    protected function mapMovie($p){
       
        
       
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

            $movie->setGenres($this->getMovieGenres($movie));

            return $movie;
       

       
    }

    protected function mapGenre($value){
        $value=is_array($value) ? $value: array();
        
        $result=array_map(function($p){
            $genre=new Genre();
            $genre->setId($p['idGenre']);
            $genre->setName($p["name"]);
     
            return $genre;
        },$value);

        return count($result)>1 ? $result: $result["0"];
    }


    }
?>