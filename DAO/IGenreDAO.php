<?php
    namespace DAO;
    
    use Models\Genre as Genre;

    interface IGenreDAO{
        function Add(Genre $genre);
        function GetAll();
    }

?>