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
        function update(Show $show);
        function getByCinemaByMovieByShift($idCinema, $idMovie, $shift);
    }

?>