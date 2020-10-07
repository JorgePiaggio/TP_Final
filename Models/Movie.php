<?php
namespace Models;

class Movie{     

    private $id;
    private $name;
    private $title;
    private $homepage; 
    private $adult;
    private $original_language;
    private $original_title;
    private $poster_path;
    private $release_date;
    private $runtime;
    private $status;
    private $spoken_languages;
    private $logo_path;
    private $origin_country;
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

    function getId(){return $this->id;}
    function getName(){return $this->name;}
    function getTitle(){return $this->title;}
    function getHomepage(){return $this->homepage;}
    function getAdult(){return $this->adult;}
    function getOriginal_language(){return $this->original_language;}
    function getOriginal_title(){return $this->original_title;}
    function getPoster_path(){return $this->poster_path;}
    function getRelease_date(){return $this->release_date;}
    function getRuntime(){return $this->runtime;}
    function getStatus(){return $this->status;}
    function getSpoken_languages(){return $this->spoken_languages;}
    function getLogo_path(){return $this->logo_path;}
    function getOrigin_country(){return $this->origin_country;}
    function getOverview(){return $this->overview;}
    function getPopularity(){return $this->popularity;}
    function getVote_average(){return $this->vote_average;}
    function getVote_count(){return $this->vote_count;}
    function getGenre(){return $this->genre;}
    function getProduction_companies(){return $this->production_companies;}
    function getProduction_countries(){return $this->production_countries;}


    function setId($id){$this->id=$id;}
    function setName($name){$this->name=$name;}
    function setTitle($title){$this->title=$title;}
    function setHomepage($homepage){$this->homepage=$homepage;}
    function setAdult($adult){$this->adult=$adult;}
    function setOriginal_language($original_language){$this->original_language=$original_language;}
    function setOriginal_title($original_title){$this->original_title=$original_title;}
    function setPoster_path($poster_path){$this->poster_path=$poster_path;}
    function setRelease_date($release_date){$this->release_date=$release_date;}
    function setRuntime($runtime){$this->runtime=$runtime;}
    function setStatus($status){$this->status=$status;}
    function setSpoken_languages($spoken_languages){$this->spoken_languages=$spoken_languages;}
    function setLogo_path($logo_path){$this->logo_path=$logo_path;}
    function setOrigin_country($origin_country){$this->origin_country=$origin_country;}
    function setOverview($overview){$this->overview=$overview;}
    function setPopularity($popularity){$this->popularity=$popularity;}
    function setVote_average($vote_average){$this->vote_average=$vote_average;}
    function setVote_count($vote_count){$this->vote_count=$vote_count;}
    function setGenre($genre){$this->genre=$genre;}
    function setProduction_companies($production_companies){$this->production_companies=$production_companies;}
    function setProduction_countries($production_countries){$this->production_countries=$production_countries;}


}
?>