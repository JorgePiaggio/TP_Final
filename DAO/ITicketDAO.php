<?php
    namespace DAO;
    
    use Models\Ticket as Ticket;

    interface ITicketDAO{
        function add(Ticket $ticket);
        function getAll();
        function search($idTicket);
        function getByShow($idShow);
        function remove($idTicket);
        function update(Ticket $ticket);
    }

?>