<?php
    namespace DAO;
    
    use Models\Seat as Seat;

    interface ISeatDAO{
        function add(Seat $seat,$idRoom);
        function getAll();
        function getbyRoom($idRoom);
        function search($idRoom,$row,$number);
        function remove($idSeat);
        function changeState(Seat $seat);
    }

?>