<?php
namespace DAO;
use Models\Room as Room;
interface IRoomDAO{
        function add(Room $room);
        function getAll();
        function changeState(Room $room);
        function search($idCinema,$number);
        function update(Room $room);
    }

    ?>