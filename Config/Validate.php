<?php

namespace Config;

class Validate{

    /* Valida que solo puedan ingresar administradores */
    static public function validateSession(){
        if(!$_SESSION || $_SESSION['role'] == 0){
            header("location:../Home/index");
        }
    }

    /* Si llegan parametros vacíos, redirige al home */
    static public function checkParameter($value=""){
        if($value=="" || empty($value)){
            header("location:../Home/index");
            
        }
    }
}
?>