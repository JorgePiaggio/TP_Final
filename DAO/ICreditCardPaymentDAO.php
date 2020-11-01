<?php
    namespace DAO;
    
    use Models\CreditCardPayment as CreditCardPayment;

    interface ICreditCardPaymentDAO{
        function add(CreditCardPayment $CreditCardPayment);
    }

?>