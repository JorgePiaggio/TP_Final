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


    public function add(Movie $movie){
        $sql = "INSERT INTO ".$this->tableName." (idMovie,title,originalTitle,voteAverage,overview,releaseDate,popularity,videoPath,adult,posterPath,backdropPath,originalLanguage,runtime,homepage,director) 
                    VALUES (:id,:title,:original_title,:vote_average,:overview,:release_date,:popularity,:videoPath,:adult,:poster_path,:backdrop_path,:original_language,:runtime,:homepage,:director)";

        $parameters["id"] = $movie->getTmdbId();
        $parameters["title"] = $movie->getTitle();
        $parameters["original_title"] = $movie->getOriginalTitle();
        $parameters["vote_average"] = $movie->getVoteAverage();
        $parameters["overview"] = $movie->getDescription();
        $parameters["release_date"] = $movie->getReleaseDate();
        $parameters["popularity"] = $movie->getPopularity();
        $parameters["videoPath"] = $movie->getVideoPath();
        $parameters["adult"] = $movie->getAdult();
        $parameters["poster_path"] = $movie->getPoster();
        $parameters["backdrop_path"] = $movie->getBackdropPath();
        $parameters["original_language"] = $movie->getOriginalLanguage();
        $parameters["runtime"] = $movie->getRuntime();
        $parameters["homepage"] = $movie->getHomepage();
        $parameters["director"] = $movie->getDirector();
        
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



    private function addGenresXMovies($genres, $IdMovie){
       
        $sql = "INSERT INTO "."moviesxgenres"." (idMovie,idGenre) VALUES (:idMovie,:idGenre)";
        
        foreach($genres as $genre){

            $parameters["idMovie"] = $IdMovie;
            $parameters["idGenre"] = $genre->getId();   
            
            try{
                $this->connection=Connection::getInstance();
                return $this->connection->executeNonQuery($sql,$parameters);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }
    }




    /* obtener todas las peliculas del DAO, activas o no */
    public function getAll(){
        try
        {
            $movieList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->execute($query);
            
            foreach ($resultSet as $row)
            {                
                $movie = $this->map($row);
                array_push($cinemaList, $movie);
            }

            return $movieList;
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }

    /* Retorna las mejores 20 peliculas según valoración */
    public function getBestRated(){
        try
        {
            $movieList = array();

            $query = "SELECT * FROM ".$this->tableName." ORDER BY voteAverage LIMIT 20";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->execute($query);
            
            foreach ($resultSet as $row)
            {                
                $movie = $this->map($row);
                array_push($movieList, $movie);
            }

            return $movieList;
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }


      /* Retorna las mejores 5 peliculas según popularidad */
      public function getMostPopular(){
        try
        {
            $movieList = array();

            $query = "SELECT * FROM ".$this->tableName." ORDER BY popularity LIMIT 5";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->execute($query);
            
            foreach ($resultSet as $row)
            {                
                $movie = $this->map($row);
                array_push($movieList, $movie);
            }

            return $movieList;
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }



    /* buscar si existe o no una pelicula en el DAO */
    public function search($tmdbId){
        try
        {
            $query = "SELECT * FROM ".$this->tableName." WHERE idMovie= :$tmdbId";

            $this->connection = Connection::getInstance();

            $result = $this->connection->execute($query);
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
 
    }


    protected function map($value){
        $value=is_array($value) ? $value: array();
        
        $result= array_map(function ($p){
            $movie=new Movie();
            $movie->setTmdbId($p["id"]);
            $movie->setTitle($p["title"]);
            $movie->setOriginalTitle($p["originalTitle"]);
            $movie->setVoteAverage($p["voteAverage"]);
            $movie->setDescription($p["overview"]);
            $movie->setReleaseDate($p["releaseDate"]);
            $movie->setPopularity($p["popularity"]);
            $movie->setVideoPath($p["videoPath"]);
            $movie->setAdult($p["adult"]);
            $movie->setPoster($p["posterPath"]);
            $movie->setBackdropPath($p["backdropPath"]);
            $movie->setOriginalLanguage($p["originalLanguage"]);
            $movie->setRuntime($p["runtime"]);
            $movie->setHomepage($p["homepage"]);
            $movie->setDirector($p["director"]);

            $genres=$this->getMovieGenres($movie->getTmdbID());
            $movie->setGenres($genres);

            return $movie;
        },$value);

        return count($result)>1 ? $result: $result["0"];
    }


    protected function getMovieGenres($idMovie){

            $genreList= array();

            $query = "SELECT * FROM "."moviesxgenres"."WHERE idMovie="."$idMovie";
            
            $this->connection = Connection::getInstance();

            $result= $this->connection->execute($query);

            $genreList= $this->mapGenre($result);

            return $genreList;
    }


    protected function mapGenre($value){
        $value=is_array($value) ? $value: array();
        
        $result=array_map(function($p){
            $genre=new Genre();
            $genre->setId($p["id"]);
            $genre->setName($p["title"]);
     
            return $genre;
        },$value);

        return count($result)>1 ? $result: $result["0"];
    }

}?>