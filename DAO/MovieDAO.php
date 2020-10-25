<?php

namespace DAO;

use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\IMovieDAO as IMovieDAO;
use DAO\GenreDAO as GenreDAO;
use DAO\Connection as Connection;


class MovieDAO implements IMovieDAO{

    private $connection;
    private $tableName="movies";


    public function add($movie){

        
        $exists=$this->search($movie->getTmdbID());

        
       
        if(!$exists){
            $sql = "INSERT INTO ".$this->tableName." (idMovie,title,originalTitle,voteAverage,overview,releaseDate,popularity,videoPath,adult,posterPath,backDropPath,originalLanguage,runtime,homepage,director,review) 
                                            VALUES (:idMovie,:title,:originalTitle,:voteAverage,:overview,:releaseDate,:popularity,:videoPath,:adult,:posterPath,:backDropPath,:originalLanguage,:runtime,:homepage,:director,:review)";


            $parameters["idMovie"] = $movie->getTmdbId();
            $parameters["title"] = $movie->getTitle();
            $parameters["originalTitle"] = $movie->getOriginalTitle();
            $parameters["voteAverage"] = $movie->getVoteAverage();
            $parameters["overview"] = $movie->getDescription();
            $parameters["releaseDate"] = $movie->getReleaseDate();
            $parameters["popularity"] = $movie->getPopularity();
            $parameters["videoPath"] = $movie->getVideoPath();
            $parameters["adult"] = $movie->getAdult();
            $parameters["posterPath"] = $movie->getPoster();
            $parameters["backDropPath"] = $movie->getBackdropPath();
            $parameters["originalLanguage"] = $movie->getOriginalLanguage();
            $parameters["runtime"] = $movie->getRuntime();
            $parameters["homepage"] = $movie->getHomepage();
            $parameters["review"] = $movie->getReview();
            $directors = implode(" - ", $movie->getDirector());
            $parameters["director"] = $directors;


            try{

            $this->connection=Connection::getInstance();

            $result=$this->connection->executeNonQuery($sql,$parameters);

            if($result > 0){    /* agregar generos x peliculas a tabla intermedia */
                $this->addGenresXMovies($movie->getGenres(),$movie->getTmdbId());
            }
            
            return $result;

            }catch(\PDOException $ex){
                throw $ex;
            }
        }
    }



    private function addGenresXMovies($genres, $IdMovie){
       
        $sql = "INSERT INTO moviesxgenres (idMovie,idGenre) VALUES (:idMovie,:idGenre)";
        $result=null;
        foreach($genres as $genre){

            $parameters["idMovie"] = $IdMovie;
            $parameters["idGenre"] = $genre->getId();   
            
            try{
                $this->connection=Connection::getInstance();
                $result+=$this->connection->executeNonQuery($sql,$parameters);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }
        return $result;
    }




    /* obtener todas las peliculas del DAO, activas o no */
    public function getAll(){
        try
        {
            $movieList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->execute($query);
            
                          
            $movieList = $this->map($resultSet);
            
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }

        if(!empty($resultSet)){
     
            return $movieList; 
        }else{
            return null;
        }
    }

    /* Retorna las mejores 20 peliculas según valoración */
    public function getBestRated(){
        try
        {
            $movieList = array();

            $query = "SELECT * FROM movies WHERE posterPath IS NOT NULL ORDER BY movies.voteAverage DESC LIMIT 20";

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query);
        }    
        catch(\PDOException $ex){
            throw $ex;
        }

        if(!empty($resultSet)){
     
            return $movieList= $this->map($resultSet); #??????? 
        }else{
            return null;
        }
    }


      /* Retorna las mejores 5 peliculas según popularidad */
      public function getMostPopular(){
        try
        {
            $movieList = array();

            $query = "SELECT * FROM movies WHERE backDropPath IS NOT NULL ORDER BY movies.popularity DESC LIMIT 5";


            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query);

            #var_dump($resultSet);
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }

        if(!empty($resultSet)){
            
            return $movieList= $this->map($resultSet);
        }else{
            return null;
        }
    }



    /* buscar si existe o no una pelicula en el DAO */
    public function search($tmdbId){
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
            return $this->map($result);
        }else{
            return null;
        }
    }

      /* retorna las peliculas por genero*/
    public function getByGenre($idGenre){
        try
        {
            $movieList = array();

            $query = "SELECT * FROM movies AS m INNER JOIN moviesxgenres AS mxg ON m.idMovie = mxg.idMovie WHERE mxg.idGenre=:idGenre";
            $parameters["idGenre"] = $idGenre;

            $this->connection = Connection::getInstance();

            $resultSet = $this->connection->execute($query, $parameters);
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


    protected function map($value){
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


    protected function getMovieGenres($movie){

            $genreList= array();

            $query = "SELECT g.idGenre, g.name FROM moviesxgenres AS mxg JOIN genres AS g ON mxg.idGenre=g.idGenre WHERE mxg.idMovie=:idMovie";

            #$parameters["idGenre"] = $idGenre;
            $parameters["idMovie"] = $movie->getTmdbId();

            $this->connection = Connection::getInstance();

            $result= $this->connection->execute($query, $parameters);
            #var_dump($result);
            $genreList= $this->mapGenre($result);

            #var_dump($genreList);

            return $genreList;
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

}?>