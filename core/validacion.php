<?php

    function validaTexto($a) {
        $patron_texto = "/[a-zA-Z0-9áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙñÑ]+$/";
        $valido = false;
        if (preg_match($patron_texto, $a) && strlen($a) < 20 && strlen($a) > 3) {
            $valido = true;
        }
        return $valido;
    }
    
	 function validaEmail($a) {
        $valido = false;
        if (filter_var($a, FILTER_VALIDATE_EMAIL)) {
            $valido = true;
        }
        return $valido;
    }
	

	function validarLongitud($a){
		$valido = false;
		if(strlen($a) < 20 || strlen($a) > 1) {
			$valido = true;
		}
		return $valido;
	}




?>