<?php
    namespace DAO;
    
    use Models\Client as Client;

    interface IClientDAO{
        function add(Client $client);
        function getAll();
        function search($idClient);
        function update(Client $client);
    }

?>