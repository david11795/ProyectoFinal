<?php

require_once 'model/Usuario.php'; //Uso de la clase Usuario
require_once 'model/Url.php';
require_once 'core/validacion.php';

if(isset($_REQUEST['salir'])){ //Si se ha pulsado el boton de salir se cierra la sesion del usuario
    unset($_SESSION['usuario']);
    session_destroy();
    header('Location: index.php');// Y se redirecciona al index
}else {// Si no, se muestra el layout de la pagina
    include 'view/layout.php';
	
	if(isset($_POST['cambiarpassword']) && !empty(trim($_POST['nuevapassword']))){
		Usuario::recuperarPassword($_SESSION['usuario'] -> email, $_POST['nuevapasswordd']);
		echo "<script> Materialize.toast('Contraseña cambiada.',3000); </script>";
		unset($_POST['cambiarpassword']);
		unset($_POST['nuevapassword']);
	} else if(isset($_POST['cambiarpassword'])){
		echo "<script> Materialize.toast('Usuario incorrecto.',3000); </script>";
	}
	
	if(isset($_POST['tlongitud']) && empty(trim($_POST['urlLong']))){
		echo "<script> Materialize.toast('Url no introducida.',3000); </script>";
	} else {
		if (isset($_POST['tlongitud']) && !filter_var($_POST['urlLong'], FILTER_VALIDATE_URL) === true){
			echo "<script> Materialize.toast('Url no valida.',3000); </script>";
		}
		if(isset($_POST['tlongitud']) && empty(trim($_POST['longitud'])) && validarLongitud($_POST['longitud'])){
			echo "<script> Materialize.toast('Longitud no valida.',3000); </script>";
		}
	}
		
	if(isset($_POST['tcustom']) && empty(trim($_POST['urlCustom']))){
		echo "<script> Materialize.toast('Url no introducida.',3000); </script>";
	} else {
		if(isset($_POST['tcustom']) && !filter_var($_POST['urlCustom'], FILTER_VALIDATE_URL) === true){
			echo "<script> Materialize.toast('Url no valida.',3000); </script>";
		}
		if(isset($_POST['tcustom']) && empty($_POST['custom'])) {
			echo "<script> Materialize.toast('Url personalizada no introducida.',3000); </script>";
		}
	}
    
}

?>