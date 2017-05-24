<?php

require_once 'model/Usuario.php'; //Uso de la clase Usuario
session_start();
require_once 'config/config.php';// Fichero con la configuración de la navegacion de la página
$controlador = 'controller/cInicio.php';// Por defecto se establece el controlador de la página de inicio

if (isset($_SESSION['usuario'])) {
    if (isset($_GET['location']) && isset($controladores[$_GET['location']])) {
        $controlador = $controladores[$_GET['location']];
    }
} else {//Si no se ha establecido localización, no se ha iniciado sesión y el controlador se establecerá como el controlador del Login
    $_GET['location'] = 'login';
    $controlador = $controladores[$_GET['location']];
}



include $controlador;//Uso del controlador.
