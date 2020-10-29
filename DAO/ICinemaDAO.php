<?php
    namespace DAO;
    
    use Models\Cinema as Cinema;

    interface ICinemaDAO{
        function add(Cinema $cinema);
        function getAll();
        function getAllActive();
        function getAllInactive();
        function changeState($idCinema);
        function search($idCinema);
        function update(Cinema $cinema);

        //Métodos de la cartelera de un cine
        function stateMovie($idCinema,$idMovie,$state);
        function addMovie($idCinema,$idMovie);
        function getBillboard($idCinema);
        
    }

?>