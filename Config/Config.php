<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//Path to your project's root folder
define("FRONT_ROOT", "/TP_Final/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "layout/styles/");
define("SCRIPT_PATH", FRONT_ROOT.VIEWS_PATH. "layout/scripts/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
define("IMG_PATH", FRONT_ROOT.VIEWS_PATH."layout/images/");
define("IMG_PATH_TICKET", VIEWS_PATH."layout/images/tickets/");
define("MODELS_PATH","Models/");
define("DAO_PATH","DAO/");
define("DB_HOST", "localhost");
define("DB_NAME", "moviepass");
define("DB_USER", "root");
define("DB_PASS", "");

/*Constantes para conectar con la API */
define("APIURL","http://api.themoviedb.org/3/");
define("POSTERURL","https://image.tmdb.org/t/p/w500/");
define("APIKEY","eb58beadef111937dbd1b1d107df8f4c");

/*Constantes de facebook */
define("APPID","372444494104218");
define("APPSECRET","584f98f8239ae686cc19ed7889d85138");
define("GRAPHVERSION",'v2.7');

?>




