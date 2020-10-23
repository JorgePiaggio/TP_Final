<?php
    namespace Controllers;

    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use DAO\MovieDAO as MovieDAO;
    use DAO\GenreDAO as GenreDAO;

    define("APIURL","http://api.themoviedb.org/3/");
    define("POSTERURL","https://image.tmdb.org/t/p/w500/");
    define("APIKEY","eb58beadef111937dbd1b1d107df8f4c");
    define("YOUTUBEURL","https://www.youtube.com/watch?v=");
    

    class MovieController{
        private $movieDAO;
        private $genreDAO;
    
        public function __construct(){
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
        }


        /* ver todas las pelis de la base de datos */
        public function showAllMovies(){
            $page = null;
            $actualGenre = null;
            $allGenre=$this->getAllGenre();
            $movieList=$this->movieDAO->getAll();
            $genreList=$this->genreDAO->getAll();
            require_once(VIEWS_PATH."Movies/Movie-list-full.php");
        }

        public function showFilterMovies(){
            $genreList=$this->genreDAO->getAll();
            require_once(VIEWS_PATH."Movies/Movie-list-full.php");
        }

        /* acomodar - llamar funcion getActive */ 
        /*
        public function ShowNowPlayingView(){
            $movieList=$this->getNowPlayingMovies();
            require_once(VIEWS_PATH."");
        } */


        /* vista de una pelicula en particular */
        public function showMovie($tmdbId){
            
            /* solicitar todos los datos de la pelicula */
            $request=file_get_contents(APIURL."movie/".$tmdbId."?api_key=".APIKEY."&language=en");
            $jsonMovie=($request) ? json_decode($request, true) : array();
            $movie=$this->constructMovie($jsonMovie);


            /* solicitar trailer de la pelicula */
            $request_two=file_get_contents(APIURL."movie/".$tmdbId."/videos?api_key=".APIKEY."&language=en-US");
            $jsonTrailer=json_decode($request_two, true);
            
            if($jsonTrailer['results'][0]['site'] == 'YouTube'){
                $movie->setVideoPath($jsonTrailer['results'][0]['key']);
            }
            
            
            /*Solicitar director/es de la pelicula*/
            $request_three = file_get_contents(APIURL."movie/".$tmdbId."/credits?api_key=".APIKEY);
            $jsonCredits = ($request_three) ? json_decode($request_three, true) : array();
            $directors = array();

            foreach($jsonCredits['crew'] as $value){
                    if(strcmp($value['job'], 'Director') == 0){ 
                        array_push($directors, $value['name']);
                    }
            }
            $movie->setDirector($directors);


            /* solicitar review */
            $request_four = file_get_contents(APIURL."movie/".$tmdbId."/reviews?api_key=".APIKEY."&language=en-US&page=1");
            $jsonCredits = ($request_four) ? json_decode($request_four, true) : array();
            if($jsonCredits['results']){
                $movie->setReview($jsonCredits['results'][0]);
            }
            
            /* https://api.themoviedb.org/3/movie/{movie_id}/reviews?api_key=<<api_key>>&language=en-US&page=1 */


            
            require_once(VIEWS_PATH."Movies/Movie-overview.php");
        }


        /* agregar peliculas nuevas y generos a los DAO  */
        public function updateMovieList($pageNumber){
            $this->validateSession();
            $nowPlaying=$this->getNowPlayingMovies($pageNumber,"en");
            $this->movieDAO->updateList($nowPlaying);
            $this->showAllMovies();
        }

        public function filterByGenre($idGenre){
            $actualGenre = null;
            if($idGenre!=-1){
            $allGenre=$this->getAllGenre();
            $movieList=$this->movieDAO->getByGenre($idGenre);
            $genreList=$this->genreDAO->getAll();
            $actualGenre=$this->genreDAO->search($idGenre);

            require_once(VIEWS_PATH."Movies/Movie-list-full.php");
            }else{
                $this->showAllMovies();
            }
        }

        /*Obtener pagina de pelicula directamente de la API*/
        public function showMoviePage($page=1,$language="en-US"){
            $allGenre=$this->getAllGenre();
            $actualGenre = null;
            $movieList=$this->getNowPlayingMovies($page,$language);
            require_once(VIEWS_PATH."Movies/Movie-list-full.php");

        }

        /* obtener de la API la lista de peliculas que se estan dando actualmente*/        
        public function getNowPlayingMovies($page, $language){     
            $this->validateSession();

            $movies= array();
            
            $request=file_get_contents(APIURL."movie/now_playing?api_key=".APIKEY."&language=".$language."&page=".$page);

            $jsonNowPlaying=($request) ? json_decode($request, true) : array();
            
            foreach($jsonNowPlaying['results'] as $valuesArray){  
                $newMovie = $this->constructMovie($valuesArray);
                array_unshift($movies, $newMovie);
            }

            return $movies;
        }


    /* construir objeto pelicula a traves del json q manda la API */
    public function constructMovie($jsonObject){
        $newMovie = new Movie();
        $newMovie->setTmdbId($jsonObject["id"]);
        $newMovie->setTitle($jsonObject["title"]);
        $newMovie->setOriginalTitle($jsonObject["original_title"]);
        $newMovie->setVoteAverage($jsonObject["vote_average"]);
        $newMovie->setDescription($jsonObject["overview"]);
        $newMovie->setReleaseDate($jsonObject["release_date"]);
        $newMovie->setPopularity($jsonObject["popularity"]);
        $newMovie->setAdult($jsonObject["adult"]);
        $newMovie->setBackdropPath($jsonObject["backdrop_path"]);
        $newMovie->setOriginalLanguage($jsonObject["original_language"]);
        if($jsonObject["homepage"]){
            $newMovie->setHomepage($jsonObject["homepage"]);
        }
        if($jsonObject["runtime"]){
            $newMovie->setRuntime($jsonObject["runtime"]);
        }
        if(!$jsonObject["poster_path"]){
            $newMovie->setPoster(IMG_PATH."banner-not.png");
        }else{
            $newMovie->setPoster(POSTERURL.$jsonObject["poster_path"]);
        }

        foreach($jsonObject["genres"] as $genre){
                $newMovie->addGenre($genre);
        }
        

        return $newMovie;
    }

        /*Genero ficticio para traer todas las películas con todos los géneros */
        public function getAllGenre(){
            $all= new Genre();
            $all->setName("All");
            $all->setId(-1);
            return $all;
        }

    
        public function validateSession(){
            if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com" || $_SESSION['role'] == 0){
                header("location:../Home/index");
            }
        }

      
}?>