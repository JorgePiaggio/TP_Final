<?php
    namespace DAO;
    
    interface IUsersReviewsDAO{
        function add($message);
        function getAll();
        function remove($message);
    }

?>