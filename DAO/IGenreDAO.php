<?php
    namespace DAO;
    
    use Models\Genre as Genre;

    interface IGenreDAO{
        function add(Genre $genre);
        function getAll();
    }

?>