<?php

namespace Models;

use Models\Genre as Genre;

class Movie{     

    private $tmdbId;
    private $title;
    private $originalTitle;
    private $voteAverage;
    private $overview;
    private $releaseDate;
    private $popularity;
    private $videoPath;
    private $adult;
    private $posterPath;
    private $backdropPath;
    private $originalLanguage;
    private $runtime;
    private $homepage;
    private $director; 
    private $review;
    private $genres;

    public function __construct(){
        $this->director = array();
        $this->genres = array();
    }

    public function getTmdbID() {return $this->tmdbId;}
    public function getTitle(){return $this->title;}
    public function getOriginalTitle(){return $this->originalTitle;}
    public function getVoteAverage() {return $this->voteAverage;}
    public function getDescription() {return $this->overview;}
    public function getReleaseDate() {return $this->releaseDate;}
    public function getPopularity() {return $this->popularity;}
    public function getVideoPath() {return $this->videoPath;}
    public function getAdult() {return $this->adult;}
    public function getPoster(){return $this->posterPath;}
    public function getBackdropPath() {return $this->backdropPath;}
    public function getOriginalLanguage() {return $this->originalLanguage;}
    public function getRuntime(){return $this->runtime;}
    public function getHomepage(){return $this->homepage;}
    public function getDirector(){return $this->director;}
    public function getReview(){return $this->review;}
    public function getGenres(){return $this->genres;}

    public function setTmdbId($id){$this->tmdbId=$id;}
    public function setTitle($title){$this->title=$title;}
    public function setOriginalTitle($originalTitle){$this->originalTitle=$originalTitle;}
    public function setVoteAverage($voteAverage){$this->voteAverage=$voteAverage;}
    public function setDescription($overview){$this->overview=$overview;}
    public function setReleaseDate($releaseDate){$this->releaseDate=$releaseDate;}
    public function setPopularity($popularity){$this->popularity=$popularity;}
    public function setVideoPath($videoPath){$this->videoPath=$videoPath;}
    public function setAdult($adult){$this->adult=$adult;}
    public function setPoster($posterPath){$this->posterPath=$posterPath;}
    public function setBackdropPath($backdropPath){$this->backdropPath=$backdropPath;}
    public function setOriginalLanguage($originalLanguage){$this->originalLanguage=$originalLanguage;}
    public function setRuntime($runtime){$this->runtime=$runtime;}
    public function setHomepage($homepage){$this->homepage=$homepage;}
    public function setDirector($director){$this->director = $director;}
    public function setReview($review){$this->review = $review;}
    public function setGenres($genres){$this->genres = $genres;}


    public function addGenre(Genre $genre){array_push($this->genres, $genre);}
}


?>