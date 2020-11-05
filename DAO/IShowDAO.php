<?php
    namespace DAO;
    
    use Models\Show as Show;

    interface IShowDAO{
        function add(Show $show);
        function getAll();
        function getAllActive();
        function getAllInactive();
        function search($idShow);
        function getByCinema($idCinema);
        function getByCinemaByMovie($idCinema, $idMovie);
        function getByDate($date);
        function getByCinemaByMovieByShift($idCinema, $idMovie, $shift);
        function getMoviesByPopularity();
        function getMoviesByRank();
        function getByRoom($idRoom);
        function update(Show $show);
    }

?>