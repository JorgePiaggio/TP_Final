<?php
    namespace DAO;
    
    use Models\Ticket as Ticket;

    interface ITicketDAO{
        function add(Ticket $ticket);
        function getAll();
        function search($idTicket);
        #function getByShow($idShow);
        #function remove($idTicket);
        #function update(Ticket $ticket);

        /* gets tickets by cinema by dates*/
        function ticketsByCinemaByDate($idCinema, $dateTime);
        function ticketsByCinemaByMonth($idCinema, $month);
        function ticketsByCinemaByYear($idCinema, $year);

        /* gets tickets by cinema by dates by shift */
        function ticketsByCinemaByShiftByDate($idCinema, $shift, $date);
        function ticketsByCinemaByShiftByMonth($idCinema, $shift, $date);
        function ticketsByCinemaByShiftByYear($idCinema, $shift, $date);
        #function ticketsByShow($idShow);
        #function ticketsByCinemaByMovie($idCinema, $idMovie);

        /* gets cash by cinema */
        function cashByCinemaByDate($idCinema, $date);
        function cashByCinemaByMonth($idCinema, $month);
        function cashByCinemaByYear($idCinema, $year);
    }

?>