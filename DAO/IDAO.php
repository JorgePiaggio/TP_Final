<?php
    namespace DAO;



    interface IDAO{
        function Add($value);
        function GetAll();
        #function ChangeState($value);
        function Search($value);
        function Update($value);
    }

?>