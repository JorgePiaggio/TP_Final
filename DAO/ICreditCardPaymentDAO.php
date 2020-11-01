<?php
    namespace DAO;
    
    use Models\CreditCardPayment as CreditCardPayment;

    interface ICreditCardPayment{
        function add(CreditCardPayment $CreditCardPayment);
    }

?>