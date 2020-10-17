<?php
    namespace DAO;
    
    use Model\Movie as Movie;

    interface IMovieDAO{
        function Add(Movie $movie);
        function GetAll();
    }

?>