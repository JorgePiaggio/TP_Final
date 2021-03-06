<?php
    namespace DAO;
    
    use Models\Movie as Movie;

    interface IMovieDAO{
        function add(Movie $movie);
        function addGenresXMovies($genres, $IdMovie);
        function getAll();
        #function getAllNotInBillboard();
        #function getBestRated();
        #sfunction getMostPopular();
        function search($tmdbId);
        function getByGenre($idGenre);
        function searchByWord($word);

    }

?>