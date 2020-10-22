<?php
namespace DAO;
use Models\Room as Room;

interface IRoomDAO{
        function add(Room $room);
        function getAll();
        function getRooms($idCinema);
        function changeState(Room $room);
        function update(Room $room);
        function getRoom($idCinema,$number);
        function getAllInactives($idCinema);
    }

    ?>