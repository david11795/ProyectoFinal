<?php

require_once 'Url.php';


$short = $_REQUEST['short'];
$busqueda = Url::buscarURL($short);

if($busqueda != ''){
	Url::incrementarVisitas($busqueda[0] -> shorturl);
	header('location: '.$busqueda[0] -> url);
}else{
	header('location: http://daviddaw2.esy.es/');
}

?>