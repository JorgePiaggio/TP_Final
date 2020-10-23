<?php
namespace DAO;
use Models\Room as Room;

interface IRoomDAO{
        function add(Room $room);
        function getAll();
        function update(Room $room);
        function search($idCinema,$number);
    }

    ?>