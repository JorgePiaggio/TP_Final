<?php

namespace DAO;

use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\IMovieDAO as IMovieDAO;


class MovieDAO implements IMovieDAO{
    private $movieList;

    public function __construct(){
        $this->movieList=array();
    }

    public function add($movie){
        $this->retrieveData();
        array_push($this->movieList, $movie);
        $this->saveData();
    }

    /* obtener todas las peliculas del DAO, activas o no */
    public function getAll(){
        $this->retrieveData();
        return $this->movieList;
    }


    /*obtener objeto pelicula por medio del id*/
    public function getMovie($imdbId){
        $this->retrieveData();
        foreach($movieList as $movie){
            if($movie->getImdbId() == $imdbId)
                return $movie;
        }
        return null;
    }


    /* agregar peliculas q no existan al DAO, luego de actualizar con la API */
    public function updateList($newMovieList){
        $this->retrieveData();
        foreach($newMovieList as $movie){
            $exists=$this->search($movie->getImdbId());
            if(!$exists){
                $this->add($movie);
            }
        }
    }


    /* buscar si existe o no una pelicula en el DAO */
    public function search($imdbId){
        $this->retrieveData();
        foreach($this->movieList as $movie){
            if($movie->getImdbId() == $imdbId)
                return true;
        }
        return false;
    }

      /* retorna las peliculas por genero*/
      public function getByGenre($idGenre){
        $movieByGenre = array();
        $this->retrieveData();
        foreach($this->movieList as $movie){
            foreach($movie->getGenreIds() as $id){
                if($id == $idGenre){
                    array_push($movieByGenre, $movie);
                }
            }
        }
        return $movieByGenre;
    }



    private function saveData(){
        $arrayToEncode = array();
        foreach($this->movieList as $movie){
            $valuesArray["id"] = $movie->getImdbId();
            $valuesArray["title"] = $movie->getTitle();
            $valuesArray["original_title"] = $movie->getOriginalTitle();
            $valuesArray["vote_average"] = $movie->getVoteAverage();
            $valuesArray["overview"] = $movie->getDescription();
            $valuesArray["release_date"] = $movie->getReleaseDate();
            $valuesArray["popularity"] = $movie->getPopularity();
            $valuesArray["video"] = $movie->getVideo();
            $valuesArray["adult"] = $movie->getAdult();
            $valuesArray["poster_path"] = $movie->getPoster();
            $valuesArray["backdrop_path"] = $movie->getBackdropPath();
            $valuesArray["original_language"] = $movie->getOriginalLanguage();
            $valuesArray["genre_ids"] = array();
                foreach($movie->getGenreIds() as $genre){
                    array_push($valuesArray["genre_ids"],$genre);
                }
            array_push($arrayToEncode, $valuesArray);
        }
        $jsonContent = json_encode($arrayToEncode , JSON_PRETTY_PRINT);
        file_put_contents('Data/movies.json', $jsonContent);
    }

    
    private function retrieveData(){
        $this->movieList = array();
        
        if(file_exists('Data/movies.json')){

            $jsonContent = file_get_contents('Data/movies.json');

            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayToDecode as $valuesArray){
                $movie = new Movie();
                $movie->setImdbId($valuesArray["id"]);
                $movie->setTitle($valuesArray["title"]);
                $movie->setOriginalTitle($valuesArray["original_title"]);
                $movie->setVoteAverage($valuesArray["vote_average"]);
                $movie->setDescription($valuesArray["overview"]);
                $movie->setReleaseDate($valuesArray["release_date"]);
                $movie->setPopularity($valuesArray["popularity"]);
                $movie->setVideo($valuesArray["video"]);
                $movie->setAdult($valuesArray["adult"]);
                $movie->setPoster($valuesArray["poster_path"]);
                $movie->setBackdropPath($valuesArray["backdrop_path"]);
                $movie->setOriginalLanguage($valuesArray["original_language"]);
                foreach($valuesArray["genre_ids"] as $genre){
                    $movie->addGenre($genre);
                }
                array_push($this->movieList, $movie);
            }
        }
    }

}?>