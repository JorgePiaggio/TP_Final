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
    define("NOPOSTER","https://image.tmdb.org/t/p/w500/");
    

    class MovieController{
        private $movieDAO;
        private $genreDAO;
    
        public function __construct(){
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
        }


        /* ver todas las pelis de la base de datos */
        public function showAllMovies(){
            $actualGenre = null;
            $allGenre=$this->getAllgenre();
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
            $movie=$this->movieDAO->constructMovie($jsonMovie);


            /* solicitar trailer de la pelicula */
            $request_two=file_get_contents(APIURL."movie/".$tmdbId."/videos?api_key=".APIKEY."&language=en-US");
            $jsonTrailer=null;
            if($request_two){
                $jsonTrailer=json_decode($request_two, true);
            }
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
            $allGenre=$this->getAllgenre();
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
            $allGenre=$this->getAllgenre();
            $actualGenre = null;
            $movies=$this->getNowPlayingMovies($page,$language);
            $movieList=$this->addNonBannerMovies($movies);
            require_once(VIEWS_PATH."Movies/Movie-list-full.php");

        }

        /*Quitar las que no tengan portada */
        public function addNonBannerMovies($movies){
            $movieList=array();

            foreach($movies as $movie){
                if($movie->getPoster()==NOPOSTER){
                    $movie->setPoster(IMG_PATH."banner-not.png");
                    #var_dump($movie);
                    }

                array_push($movieList,$movie);
            }

            return $movieList;
        }

        /* obtener de la API la lista de peliculas que se estan dando actualmente*/        
        public function getNowPlayingMovies($page, $language){     
            $this->validateSession();

            $movies= array();
            
            $request=file_get_contents(APIURL."movie/now_playing?api_key=".APIKEY."&language=".$language."&page=".$page);

            $jsonNowPlaying=($request) ? json_decode($request, true) : array();
            
            foreach($jsonNowPlaying['results'] as $valuesArray){  /* MANDAR AL DAO A Q LO CONSTRUYA */ 
                $newMovie = new Movie();
                $newMovie->setTmdbId($valuesArray["id"]);
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
                array_unshift($movies, $newMovie);
            }
            return $movies;
        }

        /*Genero ficticio para traer todas las películas con todos los géneros */
        public function getAllgenre(){
            $all= new Genre();
            $all->setName("All");
            $all->setId(-1);
            return $all;
        }

    
        public function validateSession(){
            if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com"){
                header("location:../Home/index");
            }
        }

      
}?>