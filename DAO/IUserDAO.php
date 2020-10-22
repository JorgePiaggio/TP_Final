<?php
    namespace DAO;
    
    use Models\User as User;

    interface IUserDAO{
        function add(User $user);
        function getAll();
        function search($idUser);
        function update(User $user);
    }

?>