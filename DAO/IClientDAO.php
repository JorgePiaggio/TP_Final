<?php
    namespace DAO;

    use Models\Client as Client;

    interface ICinemaDAO{
        function Add(Client $client);
        function GetAll();
        #function ChangeState($idClient);
        function Search($idClient);
        function Update(Client $client);
    }

?>