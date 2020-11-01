<?php
    namespace DAO;
    
    use Models\Seat as Seat;

    interface ISeatDAO{
        function add(Seat $seat,$idShow);
        function getAll();
        function getbyShow($idShow);
        function search($idShow,$row,$number);
        function remove($idSeat);
    }

?>