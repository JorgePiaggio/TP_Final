<?php
    namespace DAO;
    
    use Models\Cinema as Cinema;

    interface ICinemaDAO{
        function add(Cinema $cinema);
        function getAll();
        function changeState($idCinema);
        function search($idCinema);
        function update(Cinema $cinema);
    }

?>