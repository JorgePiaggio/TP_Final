<?php
    namespace DAO;
    
    use Models\CreditCard as CreditCard;

    interface ICreditCardDAO{
        function add(CreditCard $CreditCard);
        function search($numberCreditCard,$company);
        function getAll();
    }

?>