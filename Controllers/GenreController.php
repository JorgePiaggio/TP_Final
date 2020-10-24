<?php
    namespace Controllers;
    if(!$_SESSION || $_SESSION["loggedUser"]!="admin@moviepass.com" || $_SESSION['role'] == 0){
        header("location:../Home/index");
    }
    use Models\Genre as Genre;
    use DAO\GenreDAO as GenreDAO;

    define("APIURL","http://api.themoviedb.org/3/");
    define("APIKEY","eb58beadef111937dbd1b1d107df8f4c");

    class GenreController{
        private $genreDAO;
    
        public function __construct(){
            $this->genreDAO = new GenreDAO(); 
        }

         /* ver todos los generos de la base de datos 
         public function showAllGenres(){
            $genreList=$this->genreDAO->getAll();
            require_once(VIEWS_PATH."Movies/Movie-list-full.php");
        }*/

    



    }
    
?>