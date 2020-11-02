<?php
    namespace DAO;
    
    use Models\Bill as Bill;

    interface IBillDAO{
        function add(Bill $bill);
        function search($idBill);
        public function getAll();

        /* gets bills */
        function billsByDate($date);
        function billsByThisMonth();
        function billsByYear($year);
        function billsByThisYear();

        /* gets cash */
        function cashByDate($date);
        function cashByMonth();
        function cashByYear($year);
        function cashByThisYear();

    }
?>