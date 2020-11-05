<?php
namespace DAO;
use Models\Room as Room;

interface IRoomDAO{
        function add(Room $room);
        function getAll();
        function update(Room $room);
        function search($idCinema,$name);
        function getAllInactive($idCinema);
        function getAllActive($idCinema);
        function getCinemaRooms($idCinema);
        function getCinemaCapacity($cinema);
        function searchById($idRoom);

    }

    ?>