<?php
require_once 'model/Usuario.php';
require_once 'model/Url.php';
require_once 'core/validacion.php';

if (isset($_SESSION['usuario'])) {//Si se ha iniciado sesión, se redirecciona al index
    header("Location: index.php?location=inicio");
} else {//si no, se comprueba la información del login
    $loginCorrecto = false;//Variable boolean para controlar el acceso
    if (isset($_REQUEST['enviar']) && isset($_REQUEST['usuario']) && isset($_REQUEST['password'])) {//Si se ha pulsado el botón de iniciar sesión y los campos no están vacíos
        //Se valida el usuario introducido.
        $usuario = Usuario::validarUsuario(trim($_REQUEST['usuario']), hash('sha256', $_REQUEST['password']));
        if (is_null($usuario)) {//Si el usuario es un objeto nulo, impresión del error
           $error = "Usuario incorrecto";
        } else {
            $loginCorrecto = true;
        }
    }
    if ($loginCorrecto) {//Si el usuario es correcto, éste se almacena en la sesión.
		session_start();
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php?location=inicio');//Redirección al index, indicando la localización
    } else {//Si no, se muestra el layout (Que mostrará el contenido de vLogin.php)

        include 'view/layout.php';
		
		if(isset($_POST['tregistro']) && validaEmail($_POST['emailRegistro']) && Usuario::validarUsuarioEmail($_POST['emailRegistro']) == null && !empty(trim($_POST['usuarioRegistro'])) && !empty(trim($_POST['emailRegistro'])) && !empty(trim($_POST['passwordRegistro'])) && validaTexto($_POST['usuarioRegistro'])){
			Usuario::agregarUsuario($_POST['usuarioRegistro'], $_POST['emailRegistro'], hash('sha256',$_POST['passwordRegistro']));
			echo "<script> Materialize.toast('Usuario creado con exito.',3000); </script>";
			unset($_POST['usuarioRegistro']);
			unset($_POST['emailRegistro']);
			unset($_POST['passwordRegistro']);
		}else {
			if(isset($_POST['tregistro']) && !empty(trim($_POST['usuarioRegistro'])) && Usuario::validarUsuarioEmail($_POST['emailRegistro']) != null) {
				echo "<script> Materialize.toast('El usuario ya existe.',3000); </script>";
			} else if(isset($_POST['tregistro']) && empty($_POST['usuarioRegistro'])) {
				echo "<script> Materialize.toast('No has introducido nada.',3000); </script>";
			}
		}
		
		if(isset($_POST['recuperar']) && !empty(trim($_POST['nuevaPasswd']))&& validaEmail($_POST['emailPasswd']) && !empty(trim($_POST['emailPasswd']) && Usuario::validarUsuarioEmail($_POST['emailPasswd']) != null)){
			Usuario::recuperarPassword($_POST['emailPasswd'], $_POST['nuevaPasswd']);
			echo "<script> Materialize.toast('Contraseña cambiada.',3000); </script>";
			unset($_POST['recuperar']);
			unset($_POST['nuevaPassword']);
			unset($_POST['usuarioPasswd']);
		} else {
			if(isset($_POST['recuperar']) && !empty(trim($_POST['emailPasswd'])) && Usuario::validarUsuarioEmail($_POST['emailRegistro']) == null) {
				echo "<script> Materialize.toast('El usuario no existe.',3000); </script>";
			} else if(isset($_POST['recuperar'])) {
				echo "<script> Materialize.toast('No has introducido nada.',3000); </script>";
			}
		}
		
		if(isset($_POST['turl']) && empty(trim($_POST['url']))){
			echo "<script> Materialize.toast('Url no introducida.',3000); </script>";
		} else {
			if (isset($_POST['turl']) && !filter_var($_POST['url'], FILTER_VALIDATE_URL) === true){
				echo "<script> Materialize.toast('Url no valida.',3000); </script>";
			}
		}
		
		if(isset($error)){
			echo "<script> Materialize.toast('Usuario incorrecto.',3000); </script>";
		}
    }
}

?>