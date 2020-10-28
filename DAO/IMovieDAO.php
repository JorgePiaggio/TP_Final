<?php
    namespace DAO;
    
    use Models\Movie as Movie;

    interface IMovieDAO{
        function add(Movie $movie);
        function addGenresXMovies($genres, $IdMovie);
        function getAll();
        function getAllNotInBillboard();
        function getBestRated();
        function getMostPopular();
        function search($tmdbId);
        function getByGenre($idGenre);
    }

?>