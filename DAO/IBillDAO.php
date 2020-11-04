<?php
    namespace DAO;
    
    use Models\Bill as Bill;

    interface IBillDAO{
        function add(Bill $bill);
        #function search($idBill);
        function searchByCodePayment($codePayment);
        function getAll();

        /* gets bills */
        #function billsByDate($date);
        #function billsByThisMonth();
        #function billsByYear($year);
        #function billsByThisYear();

        

    }
?>