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

        /* gets tickets by cinema*/
        function ticketsByCinemaByDate($idCinema, $dateTime);
        function ticketsByCinemaByMonth($idCinema, $month);
        function ticketsByCinemaByYear($idCinema, $year);
        function ticketsByshow($idShow);
        function ticketsByCinemaByMovie($idCinema, $idMovie);
        function ticketsByCinemaByMovieByShift($idCinema, $idMovie, $shift);

        /* gets cash by cinema */
        function cashByCinemaByDate($idCinema, $date);
        function cashByCinemaByMonth($idCinema, $month);
        function cashByCinemaByYear($idCinema, $year);
    }

?>