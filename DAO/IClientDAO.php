<?php
    namespace DAO;
    
    use Models\Client as Client;

    interface IClientDAO{
        function Add(Client $client);
        function GetAll();
        function Search($idClient);
        function Update(Client $client);
    }

?>