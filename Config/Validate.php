<?php

namespace Config;

class Validate{

    /* Valida que solo puede ingresar administradores */
    static public function validateSession(){
        if(!$_SESSION || $_SESSION['role'] == 0){
            header("location:../Home/index");
        }
    }

    /* Si llegan parametros vacíoss, redirige al home */
    static public function checkParameter($value=""){
        if($value==""){
            header("location:../Home/index");
            
        }
    }
}
?>