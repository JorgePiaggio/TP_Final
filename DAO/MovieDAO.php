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

    public function Add($movie){
        $this->RetrieveData();
        array_push($this->movieList, $movie);
        $this->SaveData();
    }

    /* obtener todas las peliculas del DAO, activas o no */
    public function GetAll(){
        $this->RetrieveData();
        return $this->movieList;
    }


    /*obtener objeto pelicula por medio del id*/
    public function GetMovie($imdbId){
        $this->RetrieveData();
        foreach($movieList as $movie){
            if($movie->getImdbId() == $imdbId)
                return $movie;
        }
        return null;
    }


    /* agregar peliculas q no existan al DAO, luego de actualizar con la API */
    public function UpdateList($newMovieList){
        $this->RetrieveData();
        foreach($newMovieList as $movie){
            $exists=$this->Search($movie->getImdbId());
            if(!$exists){
                $this->Add($movie);
            }
        }
    }


    /* buscar si existe o no una pelicula en el DAO */
    public function Search($imdbId){
        $this->RetrieveData();
        foreach($this->movieList as $movie){
            if($movie->getImdbId() == $imdbId)
                return true;
        }
        return false;
    }


    private function SaveData(){
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

    
    private function RetrieveData(){
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