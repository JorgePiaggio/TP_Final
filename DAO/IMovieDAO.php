<?php
    namespace DAO;
    
    use Models\Movie as Movie;

    interface IMovieDAO{
        function add(Movie $movie);
        function getAll();
    }

?>