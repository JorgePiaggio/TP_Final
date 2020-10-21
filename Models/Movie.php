<?php
namespace Models;

class Movie{     

    private $tmdbId;
    private $title;
    private $originalTitle;
    private $voteAverage;
    private $overview;
    private $releaseDate;
    private $popularity;
    private $video;
    private $videoPath;
    private $adult;
    private $posterPath;
    private $backdropPath;
    private $originalLanguage;
    private $genreIds;
    private $active;            //true-> en una funcion actual
    private $genreStrings;      // arreglo auxiliar para string de generos, de aca para abajo no se guarda
    private $runtime;
    private $homepage;
    private $director; 

    public function __construct(){
        $this->genreIds=array();
        $this->genreStrings=array();
        $this->active=false;
        $this->director = array();
    }

    public function getTmdbID() {return $this->tmdbId;}
    public function getTitle(){return $this->title;}
    public function getOriginalTitle(){return $this->originalTitle;}
    public function getVoteAverage() {return $this->voteAverage;}
    public function getDescription() {return $this->overview;}
    public function getReleaseDate() {return $this->releaseDate;}
    public function getPopularity() {return $this->popularity;}
    public function getVideo() {return $this->video;} //true or false//
    public function getVideoPath() {return $this->videoPath;}
    public function getAdult() {return $this->adult;}
    public function getPoster(){return $this->posterPath;}
    public function getBackdropPath() {return $this->backdropPath;}
    public function getOriginalLanguage() {return $this->originalLanguage;}
    public function getGenreIds() {return $this->genreIds;}
    public function getGenreStrings() {return $this->genreStrings;}
    public function getActive(){return $this->active;}
    public function getRuntime(){return $this->runtime;}
    public function getHomepage(){return $this->homepage;}
    public function getDirector(){return $this->director;}

    public function setTmdbId($id){$this->tmdbId=$id;}
    public function setTitle($title){$this->title=$title;}
    public function setOriginalTitle($originalTitle){$this->originalTitle=$originalTitle;}
    public function setVoteAverage($voteAverage){$this->voteAverage=$voteAverage;}
    public function setDescription($overview){$this->overview=$overview;}
    public function setReleaseDate($releaseDate){$this->releaseDate=$releaseDate;}
    public function setPopularity($popularity){$this->popularity=$popularity;}
    public function setVideo($video){$this->video=$video;}
    public function setVideoPath($videoPath){$this->videoPath=$videoPath;}
    public function setAdult($adult){$this->adult=$adult;}
    public function setPoster($posterPath){$this->posterPath=$posterPath;}
    public function setBackdropPath($backdropPath){$this->backdropPath=$backdropPath;}
    public function setOriginalLanguage($originalLanguage){$this->originalLanguage=$originalLanguage;}
    public function addGenre($genre){array_push($this->genreIds,$genre);}
    public function addGenreString($genre){array_push($this->genreStrings,$genre);}
    public function setActive($value){$this->active=$value;}
    public function setRuntime($runtime){$this->runtime=$runtime;}
    public function setHomepage($homepage){$this->homepage=$homepage;}
    public function setDirector($director){$this->director = $director;}


 /*   private $id;
    private $name;
    private $title;
    private $adult;
    private $original_language;
    private $original_title;
    private $poster_path;
    private $release_date;
    private $runtime;
    private $status;
    private $spoken_languages;
    private $logo_path;
    private $overview;
    private $popularity;
    private $vote_average;
    private $vote_count;
    private $genre;
    private $production_companies;
    private $production_countries;

    function __construct(){
        $this->genre=array();
        $this->production_companies=array();
        $this->production_countries=array();
        $this->spoken_languages=array();
    }

    public function getId(){return $this->id;}
    public function getName(){return $this->name;}
    public function getTitle(){return $this->title;}
    public function getAdult(){return $this->adult;}
    public function getOriginal_language(){return $this->original_language;}
    public function getOriginal_title(){return $this->original_title;}
    public function getPoster_path(){return $this->poster_path;}
    public function getRelease_date(){return $this->release_date;}
    public function getStatus(){return $this->status;}
    public function getSpoken_languages(){return $this->spoken_languages;}
    public function getLogo_path(){return $this->logo_path;}
    public function getOverview(){return $this->overview;}
    public function getPopularity(){return $this->popularity;}
    public function getVote_average(){return $this->vote_average;}
    public function getVote_count(){return $this->vote_count;}
    public function getGenre(){return $this->genre;}
    public function getProduction_companies(){return $this->production_companies;}
    public function getProduction_countries(){return $this->production_countries;}


    public function setId($id){$this->id=$id;}
    public function setName($name){$this->name=$name;}
    public function setTitle($title){$this->title=$title;}
    public function setAdult($adult){$this->adult=$adult;}
    public function setOriginal_language($original_language){$this->original_language=$original_language;}
    public function setOriginal_title($original_title){$this->original_title=$original_title;}
    public function setPoster_path($poster_path){$this->poster_path=$poster_path;}
    public function setRelease_date($release_date){$this->release_date=$release_date;}
    public function setStatus($status){$this->status=$status;}
    public function setSpoken_languages($spoken_languages){$this->spoken_languages=$spoken_languages;}
    public function setLogo_path($logo_path){$this->logo_path=$logo_path;}
    public function setOverview($overview){$this->overview=$overview;}
    public function setPopularity($popularity){$this->popularity=$popularity;}
    public function setVote_average($vote_average){$this->vote_average=$vote_average;}
    public function setVote_count($vote_count){$this->vote_count=$vote_count;}
    public function setGenre($genre){$this->genre=$genre;}
    public function setProduction_companies($production_companies){$this->production_companies=$production_companies;}
    public function setProduction_countries($production_countries){$this->production_countries=$production_countries;}

*/
}
?>