<?php
    namespace DAO;
    
    use Model\Cinema as Cinema;

    interface ICinemaDAO{
        function Add(Cinema $cinema);
        function GetAll();
        function ChangeState($idCinema);
        function Search($idCinema);
        function Update(Cinema $cinema);
    }

?>