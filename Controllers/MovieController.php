<?php
    namespace Controllers;

    use Models\Movie as Movie;
    use Models\Genre as Genre;
    use DAO\MovieDAO as MovieDAO;
    use DAO\ShowDAO as ShowDAO;
    use DAO\GenreDAO as GenreDAO;
    use Config\Validate as Validate;
    use \Exception as Exception;


    class MovieController{
        private $movieDAO;
        private $genreDAO;
        private $showDAO;
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
            $movieList=array();

            try{
                $shows=$this->showDAO->getAll();
                if($shows){                                          
                    foreach($shows as $show){
                        if(!in_array($show->getMovie(), $movieList)) { 
                                array_push($movieList,$show->getMovie());
                        }
                    }       
                }

                $genreList=$this->genreDAO->getAll();
                
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }

            require_once(VIEWS_PATH."Movies/Movie-list-full.php");
        }


        public function showFilterMovies(){
            try{
                $genreList=$this->genreDAO->getAll();
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
            require_once(VIEWS_PATH."Movies/Movie-list-full.php");
        }
    

        public function filterByGenre($idGenre){
            $actualGenre = null;
            $movieList=array();
            if($idGenre!=-1){
                $allGenre=$this->getAllGenre();
                try{
                    $shows=$this->showDAO->getAll();
                    
                    if($shows){                                          
                        foreach($shows as $show){
                                if(!in_array($show->getMovie(), $movieList)) { 
                                    foreach($show->getMovie()->getGenres() as $genre){
                                        if($genre->getId() == $idGenre){
                                            array_push($movieList,$show->getMovie());
                                        }
                                }
                            }
                        }       
                    }
                    $actualGenre=$this->genreDAO->search($idGenre);
                    $genreList=$this->genreDAO->getAll();
                
                }catch(\Exception $e){
                    echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
                }
                
                require_once(VIEWS_PATH."Movies/Movie-list-full.php");
            }else{
                $this->showAllMovies();
            }
            
        }
    

        /* vista de una pelicula en particular */
        public function showMovie($tmdbId=""){
            Validate::checkParameter($tmdbId);

            try{
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
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
            require_once(VIEWS_PATH."Movies/Movie-overview.php");
        }


        /*Obtener pagina de pelicula directamente de la API*/
        public function showMoviePage($page=1, $language="en-US"){   
            Validate::validateSession();

            $allGenre=$this->getAllGenre();
            $actualGenre = null; 
            try{
                $this->updateGenreList();                                 
                $genreList=$this->genreDAO->getAll();
                $movieList=$this->getNowPlayingMovies($page,$language);
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
            require_once(VIEWS_PATH."Movies/Movie-list-admin.php");
        }


        /* solicitar detalles de la pelicula */
        public function getMovieDetails($tmdbId=""){
            Validate::checkParameter($tmdbId);

            try{
                $request=file_get_contents(APIURL."movie/".$tmdbId."?api_key=".APIKEY."&language=en");
                #$request=false; /* testing exceptions */ 
                if($request === FALSE){
                    throw new Exception("Cannot access API to read contents.");
                }else{
                    $jsonMovie=($request) ? json_decode($request, true) : array();
                }
            }catch(\Exception $e){
            #  echo "Caught Exception: ".get_class($e)." - ".;     
                header("location:../../Home/index?alert=".$e->getMessage()); 
            }

            return $jsonMovie;
        }

        
        /* solicitar trailer de la pelicula */
        public function getVideoTrailer($tmdbId=""){ 
            Validate::checkParameter($tmdbId);

            try{
                $request_two=file_get_contents(APIURL."movie/".$tmdbId."/videos?api_key=".APIKEY."&language=en-US");
                if($request_two === FALSE){
                    throw new Exception("Cannot access API to read contents.");
                }else{
                    $jsonTrailer=json_decode($request_two, true);
                }
          

                $trailer=null;

                if($jsonTrailer['results'] != null){
                    if($jsonTrailer['results'][0] != null){
                        if($jsonTrailer['results'][0]['site'] == 'YouTube'){
                            $trailer = $jsonTrailer['results'][0]['key'];
                        }
                    }
                }
                return $trailer;

            }catch(\Exception $e){
                header("location:../../Home/index?alert=".$e->getMessage()); 
            }
        }


        /* solicitar director de la pelicula */
        public function getDirector($tmdbId=""){
            Validate::checkParameter($tmdbId);

            try{
                $request_three = file_get_contents(APIURL."movie/".$tmdbId."/credits?api_key=".APIKEY);
                if($request_three === FALSE){
                    throw new Exception("Cannot access API to read contents.");
                }else{
                $jsonCredits = ($request_three) ? json_decode($request_three, true) : array();
                }

                $directors = array();

                foreach($jsonCredits['crew'] as $value){
                    if(strcmp($value['job'], 'Director') == 0){ 
                        array_push($directors, $value['name']);
                    }
                }
            }catch(\Exception $e){
                header("location:../../Home/index?alert=".$e->getMessage()); 
            }

            return $directors;
        }


         /* solicitar review */
        public function getReview($tmdbId=""){
            Validate::checkParameter($tmdbId);

            try{
                $request_four = file_get_contents(APIURL."movie/".$tmdbId."/reviews?api_key=".APIKEY."&language=en-US&page=1");

                if($request_four === FALSE){
                    throw new Exception("Cannot access API to read contents.");
                }else{
                    $jsonCredits = ($request_four) ? json_decode($request_four, true) : array();
                }
                $json=null;
                if($jsonCredits['results']){
                    $json=($jsonCredits['results'][0]);
                }
            }catch(\Exception $e){
                header("location:../../Home/index?alert=".$e->getMessage()); 
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
            Validate::checkParameter($page);
            Validate::validateSession();

            $movies= array();

            try{
                $request=file_get_contents(APIURL."movie/now_playing?api_key=".APIKEY."&language=".$language."&page=".$page);
                if($request === FALSE){
                    throw new Exception("Cannot access API to read contents.");
                }else{
                    $jsonNowPlaying=($request) ? json_decode($request, true) : array();
                }
                
                foreach($jsonNowPlaying['results'] as $valuesArray){  
                    $newMovie = $this->constructMovie($valuesArray);
                    array_unshift($movies, $newMovie);
                }
            }catch(\Exception $e){
                header("location:../../Home/index?alert=".$e->getMessage()); 
            }
            return $movies;
        }



        /* agregar o quitar peliculas al catalogo para que esten disponibles para shows -> cambia estado de movie en la bdd */
        public function showManageCatalogue(){
            Validate::validateSession();

            try{
                $movieListInactive=$this->movieDAO->getAllStateZero();
                $movieListActive=$this->movieDAO->getAllStateOne();
                $genreList=$this->genreDAO->getAll();
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
            require_once(VIEWS_PATH."Movies/Movie-catalogue.php");
        }



        /*agregar multiples peliculas a la BDD*/
        public function addMultipleMovies($movies=""){
            Validate::checkParameter($movies);
            Validate::validateSession();

            $result = null;
            if($movies){
                foreach($movies as $idMovie){
                    $result+= $this->addMovieToDatabase($idMovie);
                }
                if($result > 0){
                    $this->msg="Movies Added Succesfully";
                }else{
                    $this->msg="Error. Selected movies were already in MoviePass collection";
                }
            }else{
                $this->msg="You must select a Movie";
            }
            $this->showMoviePage();
        }


        /* agregar pelicula a la BDD */
        public function addMovieToDatabase($tmdbId=""){
            Validate::checkParameter($tmdbId);
            Validate::validateSession();    

            /* solicitar detalles de la pelicula */
            $jsonMovie=$this->getMovieDetails($tmdbId);
            $movie=$this->constructMovie($jsonMovie);

            /* solicitar trailer de la pelicula */
            $trailer=$this->getVideoTrailer($tmdbId);
            $movie->setVideoPath($trailer);
            
            /*Solicitar director/es de la pelicula*/
            $directors = $this->getDirector($tmdbId);
            $movie->setDirector($directors);

            try{
                $result=$this->movieDAO->add($movie);
                if($result > 0){
                    $this->msg= "Movies Added Succesfully";
                }else{
                    $this->msg="Error. Selected movies were already in MoviePass collection";
                }
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }

            $this->showMoviePage();
        }



        public function changeState(){
            Validate::validateSession();

            $alert=false; // flag para activar el mensaje
            $cant=0; // contador para peliculas que tengan funciones activas
            if($_POST){
                $movies=$_POST["movies"];
                try{
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
                }catch(\Exception $e){
                    echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
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

            try{
                $genres=$this->genreDAO->getAll();
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }

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
            try{
                foreach($nowGenre as $genre){
                    $this->genreDAO->add($genre);
                }
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
        }

    
        /* obtener de la API la lista de generos actuales    */ 
        private function getNowGenres($language="en"){
            Validate::validateSession();
            
            $genres= array();

            try{
                $request=file_get_contents(APIURL."genre/movie/list?api_key=".APIKEY."&language=".$language);

                if($request === FALSE){
                    throw new Exception("Cannot access API to read contents.");
                }else{
                    $jsonNowPlaying=($request) ? json_decode($request, true) : array();
                
                    foreach($jsonNowPlaying['genres'] as $valuesArray){
                        $newGenre = new Genre();
                        $newGenre->setId($valuesArray["id"]);
                        $newGenre->setName($valuesArray["name"]);
                        array_push($genres, $newGenre);
                    }
                }
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
            
            return $genres;
    
        }


        /* buscar peliculas por coincidencia de palabra en titulo */
        public function searchMovie($string=""){

            $movieList=array();
            $movieListResults=array();

            try{
                $showList= $this->showDAO->getAll();                        //todos los shows
                $movieListPre= $this->movieDAO->searchByWord($string);      //todas las pelis que coinciden con la busqueda

                if(isset($movieListPre)){   //MALDITO FOREACH   
                    if(!is_array($movieListPre)){
                        array_push($movieListResults, $movieListPre);
                    }else{
                        $movieListResults = $movieListPre;
                    }
                }

                if(!empty($movieListResults) && !empty($showList)){
                    foreach($movieListResults as $movie){
                        foreach($showList as $showMovie){
                            if($showMovie->getMovie()->getTmdbId() == $movie->getTmdbId()){
                                if(!in_array($movie, $movieList)){
                                    array_push($movieList,$movie);                 // filtro: si las pelis estan o estuvieron en un show se muestran al user
                                }
                            }
                        }
                    }
               
                }

            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }
    
            require_once(VIEWS_PATH."Movies/Show-search-results.php");
    
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

            try{
                $this->genreDAO->add($null);
            }catch(\Exception $e){
                echo "Caught Exception: ".get_class($e)." - ".$e->getMessage();
            }

            return $null;
        }
}
?>