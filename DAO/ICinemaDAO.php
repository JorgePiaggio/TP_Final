<?php
    namespace DAO;

    use Models\Cinema as Cinema;

    interface ICinemaDAO{
        function Add(Cinema $cinema);
        function GetAll();
        function Remove($idCinema);
        function Search($idCinema);
        function Update(Cinema $Cinema);
    }

?>