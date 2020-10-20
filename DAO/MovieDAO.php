<?php

namespace DAO;

use Models\Movie as Movie;
use Models\Genre as Genre;
use DAO\GenreDAO as GenreDAO;
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
        $this->movieList=$this->genreToString($this->movieList);
        return $this->movieList;
    }

    /* Retorna las mejores 20 peliculas según valoración */
    public function getBestRated(){
        $this->retrieveData();
        $indice=0;
        $bestRated = array();

        usort($this->movieList, function($a, $b){
            return $a->getVoteAverage() < $b->getVoteAverage();
        });

        foreach ($this->movieList as $movie){
            if($indice < 20){
                array_push($bestRated, $movie);
                $indice++;
            }
        }
        $bestRated=$this->genreToString($bestRated);

        return $bestRated;
    }


    /*obtener objeto pelicula por medio del id*/
    public function getMovie($tmdbId){
        $this->retrieveData();
        foreach($this->movieList as $movie){
            if($movie->getTmdbId() == $tmdbId)
                return $movie;
        }
        return null;
    }


    /* agregar peliculas q no existan al DAO, luego de actualizar con la API */
    public function updateList($newMovieList){
        $this->retrieveData();
        foreach($newMovieList as $movie){
            $exists=$this->search($movie->getTmdbId());
            if(!$exists){
                $this->add($movie);
            }
        }
    }


    /* buscar si existe o no una pelicula en el DAO */
    public function search($tmdbId){
        $this->retrieveData();
        foreach($this->movieList as $movie){
            if($movie->getTmdbId() == $tmdbId)
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
        $movieByGenre=$this->genreToString($movieByGenre);

        return $movieByGenre;
    }



    /* construir objeto pelicula a traves del json q manda la API, devolver al controller */
    public function constructMovie($jsonObject){
        $newMovie = new Movie();
        $newMovie->setTmdbId($jsonObject["id"]);
        $newMovie->setTitle($jsonObject["title"]);
        $newMovie->setOriginalTitle($jsonObject["original_title"]);
        $newMovie->setVoteAverage($jsonObject["vote_average"]);
        $newMovie->setDescription($jsonObject["overview"]);
        $newMovie->setReleaseDate($jsonObject["release_date"]);
        $newMovie->setPopularity($jsonObject["popularity"]);
        $newMovie->setVideo($jsonObject["video"]);
        $newMovie->setAdult($jsonObject["adult"]);
        $newMovie->setRuntime($jsonObject["runtime"]);
        $newMovie->setHomepage($jsonObject["homepage"]);
        $newMovie->setPoster(POSTERURL.$jsonObject["poster_path"]);
        $newMovie->setBackdropPath($jsonObject["backdrop_path"]);
        $newMovie->setOriginalLanguage($jsonObject["original_language"]);
        foreach($jsonObject["genres"] as $genre){
            $newMovie->addGenre($genre);
        }
        $newMovie=$this->genreToString($newMovie);

        return $newMovie;
    }


    /* insertar strings de genero en peliculas */
    public function genreToString($movieList){

        $genreDAO= new GenreDAO();     
        $genreList=$genreDAO->getAll();
        $aux=null;

        foreach($movieList as $movie){
            foreach($movie->getGenreIds() as $genreId){
                foreach($genreList as $genre){
                    if($genre->getId() == $genreId){
                    $movie->addGenreString($genre->getName());
                    }
                }
            }
        }
        return $movieList;
    }


    private function saveData(){
        $arrayToEncode = array();
        foreach($this->movieList as $movie){
            $valuesArray["id"] = $movie->getTmdbId();
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
                $movie->setTmdbId($valuesArray["id"]);
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