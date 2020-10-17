<?php
    namespace Controllers;

    if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com"){
        header("location:../Home/Index");
    }

    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use DAO\MovieDAO as MovieDAO;

    define("APIURL","http://api.themoviedb.org/3/");
    define("POSTERURL","https://image.tmdb.org/t/p/w500/");
    define("APIKEY","eb58beadef111937dbd1b1d107df8f4c");

    class MovieController{
        private $MovieDAO;
    
        public function __construct(){
            $this->MovieDAO = new MovieDAO(); 
        }


        /* ver todas las pelis de la base de datos */
        public function ShowAllMovies(){
            $movieList=$this->MovieDAO->GetAll();
            require_once(VIEWS_PATH."Movies/Movie-list-full.php");
        }


        /* acomodar - llamar funcion getActive */ 
        /*
        public function ShowNowPlayingView(){
            $movieList=$this->getNowPlayingMovies();
            require_once(VIEWS_PATH."");
        } */


        /* vista de una pelicula en particular */
        public function ShowMovie($imdbId){
            $movie=$this->GetMovieData($imdbId);
            require_once(VIEWS_PATH."");
        }

        
        /*pedir data de una peli */
        public function GetMovieData($imdbId){
            $movie=$this->MovieDAO->GetMovie($imdbId);
        }


        /* agregar peliculas nuevas al DAO */
        public function UpdateMovieList(){
            $nowPlaying=$this->GetNowPlayingMovies();
            $this->MovieDAO->UpdateList($nowPlaying);
            $this->ShowAllMovies();
        }


        /* obtener de la API la lista de peliculas que se estan dando actualmente*/        
        public function GetNowPlayingMovies($page = 1,$language="en"){
            $movies= array();
            
            $request=file_get_contents(APIURL."movie/now_playing?api_key=".APIKEY."&language=".$language."page=".$page);
            
            $jsonNowPlaying=($request) ? json_decode($request, true) : array();
            
            foreach($jsonNowPlaying['results'] as $valuesArray){
                $newMovie = new Movie();
                $newMovie->setImdbId($valuesArray["id"]);
                $newMovie->setTitle($valuesArray["title"]);
                $newMovie->setOriginalTitle($valuesArray["original_title"]);
                $newMovie->setVoteAverage($valuesArray["vote_average"]);
                $newMovie->setDescription($valuesArray["overview"]);
                $newMovie->setReleaseDate($valuesArray["release_date"]);
                $newMovie->setPopularity($valuesArray["popularity"]);
                $newMovie->setVideo($valuesArray["video"]);
                $newMovie->setAdult($valuesArray["adult"]);
                $newMovie->setPoster(POSTERURL.$valuesArray["poster_path"]);
                $newMovie->setBackdropPath($valuesArray["backdrop_path"]);
                $newMovie->setOriginalLanguage($valuesArray["original_language"]);
                foreach($valuesArray["genre_ids"] as $genre){
                    $newMovie->addGenre($genre);
                }
                array_push($movies, $newMovie);
            }
        return $movies;
        }



    /* GET VIDEOS ---> EXAMPLE URL

    http://api.themoviedb.org/3/movie/157336/videos?api_key=###
    
    */                    

}?>