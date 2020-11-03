<?php
    namespace Controllers;

    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use DAO\MovieDAO as MovieDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\GenreDAO as GenreDAO;
    use Config\Validate as Validate;


    class MovieController{
        private $movieDAO;
        private $genreDAO;
        private $msg;
    
        public function __construct(){
            $this->movieDAO = new MovieDAO();
            $this->genreDAO = new GenreDAO();
            $this->showDAO = new ShowDAO();
            $this->msg = null;
            $this->addNullGenre();
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
    

        /* vista de una pelicula en particular */
        public function showMovie($tmdbId){

            /* solicitar detalles de la pelicula */
            $jsonMovie=$this->getMovieDetails($tmdbId);
            $movie=$this->constructMovie($jsonMovie);

            /* solicitar trailer de la pelicula */
            $trailer=$this->getVideoTrailer($tmdbId);
            $movie->setVideoPath($trailer);
            
            /*Solicitar director/es de la pelicula*/
            $directors = $this->getDirector($tmdbId);
            $movie->setDirector($directors);

            /* solicitar review */
            $review=$this->getReview($tmdbId);
            $movie->setReview($review);
            
             /* solicitar funciones de la muvi */
            $showList=$this->showDAO->getAllByMovie($tmdbId);
            
            require_once(VIEWS_PATH."Movies/Movie-overview.php");
        }


        /*Obtener pagina de pelicula directamente de la API*/
        public function showMoviePage($page=1,$language="en-US"){
            Validate::validateSession();

            $allGenre=$this->getAllGenre();
            $actualGenre = null; 
            $this->updateGenreList();                                 
            $genreList=$this->genreDAO->getAll();
            $movieList=$this->getNowPlayingMovies($page,$language);
            require_once(VIEWS_PATH."Movies/Movie-list-admin.php");
        }


        /* solicitar detalles de la pelicula */
        public function getMovieDetails($tmdbId){
            $request=file_get_contents(APIURL."movie/".$tmdbId."?api_key=".APIKEY."&language=en");
            $jsonMovie=($request) ? json_decode($request, true) : array();
            
            return $jsonMovie;
        }

        
        /* solicitar trailer de la pelicula */
        public function getVideoTrailer($tmdbId){  
            $request_two=file_get_contents(APIURL."movie/".$tmdbId."/videos?api_key=".APIKEY."&language=en-US");
            $jsonTrailer=json_decode($request_two, true);
            
            $trailer=null;

            if($jsonTrailer['results'] != null){
                if($jsonTrailer['results'][0] != null){
                    if($jsonTrailer['results'][0]['site'] == 'YouTube'){
                        $trailer = $jsonTrailer['results'][0]['key'];
                    }
                }
            }
            return $trailer;
        }


        /* solicitar director de la pelicula */
        public function getDirector($tmdbId){
            $request_three = file_get_contents(APIURL."movie/".$tmdbId."/credits?api_key=".APIKEY);
            $jsonCredits = ($request_three) ? json_decode($request_three, true) : array();
            $directors = array();

                foreach($jsonCredits['crew'] as $value){
                    if(strcmp($value['job'], 'Director') == 0){ 
                        array_push($directors, $value['name']);
                    }
                }
            return $directors;
        }


         /* solicitar review */
        public function getReview($tmdbId){
            $request_four = file_get_contents(APIURL."movie/".$tmdbId."/reviews?api_key=".APIKEY."&language=en-US&page=1");
            $jsonCredits = ($request_four) ? json_decode($request_four, true) : array();
            $json=null;
            if($jsonCredits['results']){
                $json=($jsonCredits['results'][0]);
            }
            return $json;
        }


        /* pedir peliculas nuevas y generos a la API  
        public function updateMovieList($pageNumber){
            $this->validateSession();
            $nowPlaying=$this->getNowPlayingMovies($pageNumber,"en");
            $this->movieDAO->updateList($nowPlaying);
            $this->showAllMovies();
        }*/


        /* obtener de la API la lista de peliculas que se estan dando actualmente*/        
        public function getNowPlayingMovies($page, $language){     
            Validate::validateSession();
            Validate::checkParameter($page);

            $movies= array();
            
            $request=file_get_contents(APIURL."movie/now_playing?api_key=".APIKEY."&language=".$language."&page=".$page);

            $jsonNowPlaying=($request) ? json_decode($request, true) : array();
            
            foreach($jsonNowPlaying['results'] as $valuesArray){  
                $newMovie = $this->constructMovie($valuesArray);
                array_unshift($movies, $newMovie);
            }

            return $movies;
        }



        /* agregar o quitar peliculas al catalogo para que esten disponibles para shows -> cambia estado de movie en la bdd */
        public function showManageCatalogue(){

            $movieListInactive=$this->movieDAO->getAllStateZero();
            $movieListActive=$this->movieDAO->getAllStateOne();
            $genreList=$this->genreDAO->getAll();
            require_once(VIEWS_PATH."Movies/Movie-catalogue.php");
        }



        /*agregar multiples peliculas a la BDD*/
        public function addMultipleMovies($movies=""){
            Validate::validateSession();
            Validate::checkParameter($movies);
            $result = null;
            if($movies){
                foreach($movies as $idMovie){
                    $result+= $this->addMovieToDatabase($idMovie);
                }
                if($result > 0){
                    $this->msg="Movies Added Correctly";
                }else{
                    $this->msg="Internal error. Please try again later";
                }
            }else{
                $this->msg="You must select a Movie";
            }
            $this->showMoviePage();
        }


        /* agregar peliculas a la BDD */
        public function addMovieToDatabase($tmdbId=""){
            Validate::validateSession();
            Validate::checkParameter($tmdbId);

            /* solicitar detalles de la pelicula */
            $jsonMovie=$this->getMovieDetails($tmdbId);
            $movie=$this->constructMovie($jsonMovie);

            /* solicitar trailer de la pelicula */
            $trailer=$this->getVideoTrailer($tmdbId);
            $movie->setVideoPath($trailer);
            
            /*Solicitar director/es de la pelicula*/
            $directors = $this->getDirector($tmdbId);
            $movie->setDirector($directors);

            $result=$this->movieDAO->add($movie);
        
            if($result > 0){
                $this->msg= "Movie Added Succesfully";
            }else{
                $this->msg="Internal error. Please try again later";
            }

            $this->showMoviePage();
        }



        public function changeState(){
            $alert=false; // flag para activar el mensaje
            $cant=0; // contador para peliculas que tengan funciones activas
            if($_POST){
                $movies=$_POST["movies"];
                foreach($movies as $id){
                    $activeShows=$this->showDAO->getAllbyMovie($id); 
                    
                    if(!$activeShows){
                        $movie= $this->movieDAO->search($id);   
                    
                        if($movie->getState() == true){
                            $this->movieDAO->setState($movie->getTmdbId(), intval(false));
                        }else{
                            $this->movieDAO->setState($movie->getTmdbId(), intval(true));
                        }
                    }else{
                        $alert=true;
                        $cant++;
                    }
                }

                if($alert){
                    $this->msg= $cant." "."movie/s can't be removed because they are on a show";
                }
            }
            $this->showManageCatalogue();
        }



        /* construir objeto pelicula a traves del json q manda la API */
        public function constructMovie($jsonObject=""){
            #Validate::validateSession(); se necesita para el anonimo
            Validate::checkParameter($jsonObject);

            $newMovie = new Movie();
            $newMovie->setTmdbId($jsonObject["id"]);
            $newMovie->setTitle($jsonObject["title"]);
            $newMovie->setOriginalTitle($jsonObject["original_title"]);
            $newMovie->setVoteAverage($jsonObject["vote_average"]);
            $newMovie->setDescription($jsonObject["overview"]);
            $newMovie->setReleaseDate($jsonObject["release_date"]);
            $newMovie->setPopularity($jsonObject["popularity"]);
            //$newMovie->setAdult($jsonObject["adult"]);
            $newMovie->setBackdropPath($jsonObject["backdrop_path"]);
            $newMovie->setOriginalLanguage($jsonObject["original_language"]);
            $newMovie->setState(true);
            if(isset($jsonObject["homepage"])){
                $newMovie->setHomepage($jsonObject["homepage"]);
            }
            if(isset($jsonObject["runtime"])){
                $newMovie->setRuntime($jsonObject["runtime"]);
            }
            if(!isset($jsonObject["poster_path"])){
                $newMovie->setPoster(IMG_PATH."banner-not.png");
            }else{
                $newMovie->setPoster(POSTERURL.$jsonObject["poster_path"]);
            }

            $genres=$this->genreDAO->getAll();
            
            if(isset($jsonObject["genre_ids"])){
                foreach($jsonObject["genre_ids"] as $genreId){  /* crea objeto Genre por cada id de genero q manda la API en getNowPlaying */ 
                    foreach($genres as $genre){
                        if($genreId == $genre->getId()){
                            $newGenre = new Genre();
                            $newGenre->setId($genreId);
                            $newGenre->setName($genre->getName());
                            $newMovie->addGenre($newGenre);
                        }
                    }    
                }
            }
            if(isset($jsonObject["genres"])){
                foreach($jsonObject["genres"] as $genre){  /* objeto Genre q manda la API cuando se pide detalle de Movie */ 
                            $newGenre = new Genre();
                            $newGenre->setId($genre['id']);
                            $newGenre->setName($genre['name']);
                            $newMovie->addGenre($newGenre);
                }    
            }
            if(empty($newMovie->getGenres())){     /* si la pelicula no tiene genero se setea en null para q no rompa las pelotas */
                $newMovie->addGenre($this->addNullGenre());
            }

            return $newMovie;
        }


        /* agregar generos al DAO  */
        public function updateGenreList(){
            Validate::validateSession();
            $nowGenre=$this->getNowGenres();
            foreach($nowGenre as $genre){
                $this->genreDAO->add($genre);
            }
        }

    
        /* obtener de la API la lista de generos actuales    */ 
        private function getNowGenres($language="en"){
            Validate::validateSession();
            
            $genres= array();

            $request=file_get_contents(APIURL."genre/movie/list?api_key=".APIKEY."&language=".$language);

            $jsonNowPlaying=($request) ? json_decode($request, true) : array();
        
            foreach($jsonNowPlaying['genres'] as $valuesArray){
                $newGenre = new Genre();
                $newGenre->setId($valuesArray["id"]);
                $newGenre->setName($valuesArray["name"]);
                array_push($genres, $newGenre);
            }
            return $genres;
    
        }


        /*Genero ficticio para traer todas las películas con todos los géneros */
        private function getAllGenre(){
            $all= new Genre();
            $all->setName("All");
            $all->setId(-1);
            return $all;
        }

        
        private function addNullGenre(){
            $null= new Genre();
            $null->setName("Undefined");
            $null->setId(-33);
            $this->genreDAO->add($null);
            return $null;
        }
}
?>