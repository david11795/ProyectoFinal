<?php
	$total_registros = Url::totalRegistros($_SESSION['usuario'] -> user);
	$url_pagina = 4;
	$total_paginas = ceil(($total_registros+1) / $url_pagina);
	$pagina = $_GET['page'];
	
	if(!$pagina){	
		$inicio = 0; 
		$pagina = 1;
	}else {
		$inicio = ($pagina - 1) * $url_pagina;
	}
	
	if(isset($_REQUEST['shorturl'])){
		Url::borrarURL($_REQUEST['shorturl']);
		unset($_REQUEST['shorturl']);
		$url = Url::listar($_SESSION['usuario'] -> user, $inicio);
	}
	
	if(isset($_POST['tlongitud']) && !empty($_POST['urlLong']) && !empty($_POST['longitud']) && trim($_POST['urlLong']) && validarLongitud($_POST['longitud']) && !filter_var($_POST['urlLong'], FILTER_VALIDATE_URL) === false){
		Url::createHashLargo(trim($_POST['urlLong']),$_POST['longitud'], $_SESSION['usuario'] -> user);	
		unset($_POST['urlLong']);
		unset($_POST['longitud']);
		unset($_POST['tlongitud']);
		$url = Url::listar($_SESSION['usuario'] -> user, $inicio);
	}
	
	if(isset($_POST['tcustom']) && !empty($_POST['urlCustom']) && !empty(trim($_POST['custom']))  && trim($_POST['urlCustom']) && !filter_var($_POST['urlCustom'], FILTER_VALIDATE_URL) === false){
		Url::createCustomUrl(trim($_POST['urlCustom']),trim($_POST['custom']), $_SESSION['usuario'] -> user);
		unset($_POST['urlCustom']);
		unset($_POST['custom']);
		unset($_POST['tcustom']);
		$url = Url::listar($_SESSION['usuario'] -> user, $inicio);
	}
	
	if(isset($_REQUEST['cerrarcuenta'])){
		Usuario::borrarUsuario($_SESSION['usuario'] -> user);
		Url::borrarUrlUsuario($_SESSION['usuario'] -> user);
		unset($_REQUEST['cerrarcuenta']);
		session_destroy();
		header('location: index.php');
	}

	
?>
<header>
	<nav>
		<div class="nav-wrapper">
			<a href="index.php" class="brand-logo left">ShortUrl</a>
			<ul class="right hide-on-med-and-down">
				<li>
					<a style="width:170px;text-transform: uppercase;" class="dropdown-button center" href="#perfil" data-activates="logout"> 
						<?php echo $_SESSION['usuario'] -> user; ?>
					</a>
				</li>			
				<!-- Dropdown Structure -->
				<ul id='logout' class='dropdown-content'>
					<li><a style="width:170px !important; height: 56px;" class="center" href="#perfil">Perfil</a></li>
					<li><a style="width:170px !important; height: 56px;" class="center" href="index.php?location=inicio&salir">Cerrar sesión</a></li>
				</ul>
			</ul>
		</div>
	</nav>
</header>
<div id="particles-js"></div>
<main>
	<div class="container" style="height:100%;">
		<div class="row centrar2">
			<form class="col s12" autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?location=inicio&page=1">
				<div class="input-field col s8 fondoInput2">
					<input id="urlLong" type="text" name="urlLong">
					<label for="urlLong">Introduce url</label>
				</div>
				<div class="input-field col s2 fondoInput3">
					<input id="longitud" type="number" name="longitud" max="20" min="1">
					<label for="longitud"> Longitud 1-20 </label>
				</div>
				<div class="input-field col s2 buttonInput">
					<button class="waves-effect waves-light btn buttonInput" type="submit" name="tlongitud">
						ACORTAR
					</button>
				</div>
			</form>
		</div>
		<div class="row centrar2">
			<form class="col s12" autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?location=inicio&page=1">
				<div class="input-field col s8 fondoInput2">
					<input id="urlCustom" type="text" name="urlCustom">
					<label for="urlCustom">Introduce url</label>
				</div>
				<div class="input-field col s2 fondoInput3">
					<input id="custom" type="text" name="custom" size="25">
					<label for="custom"> Url personalizada </label>
				</div>
				<div class="input-field col s2 buttonInput">
					<button class="waves-effect waves-light btn buttonInput" type="submit" name="tcustom">
						ACORTAR
					</button>
				</div>
			</form>
		</div>
		<br>
		<br>
		<div class="row centrar2">
			<table class="centered bordered fondoInput responsive-table">
				<tbody>
					<tr>
						<td> URL </td>
						<td> URL ACORTADA </td>
						<td> VISITAS </td>
						<td> FECHA DE CREACION </td>
						<td>  </td>
					</tr>
					<?php   
						$url = Url::listar($_SESSION['usuario'] -> user, $inicio);
						if($url != null){
							for($i = 0; $i < count($url);$i++){ ?>
								<tr>
									<td> <span class="span1"><?php  echo $url[$i] -> url; ?></span> </td>
									<td> 
										<a href="<?php echo $url[$i] -> shorturl;  ?>" target="_blank" > 
											<?php echo $_SERVER['SERVER_NAME']."/".$url[$i] -> shorturl;  ?> 
										</a> 
									</td>
									<td> <?php  echo $url[$i] -> visitas; ?> </td>
									<td> <?php  echo $url[$i] -> fechaCreacion; ?> </td>
									<td>
										<a class="black-text" href="index.php?location=inicio&shorturl=<?php echo $url[$i] -> shorturl; ?>" style="cursor:pointer;" onClick="return confirm('¿Estas seguro?');"> 
											<i class="center small material-icons">delete</i> 
										</a> 
									</td>
								</tr>
					<?php	}
						} else { ?>
							<tr>
								<td>
									No has acortado ninguna url.
								</td>
						<?php	
						} 
					?>
							</tr>
				</tbody>
			</table>
			<ul class="pagination">
				<?php
					if($total_paginas > 1) {
						for($i = 1; $i <= $total_paginas;$i++){
							if($_GET['page'] == $i){
							?>
								<li class="waves-effect active"> <a href="index.php?location=inicio&page=<?php echo $i; ?>"> <?php echo $i; ?> </a> </li>	
							<?php 
							} else {
							?>
								<li class="waves-effect"> <a href="index.php?location=inicio&page=<?php echo $i; ?>"> <?php echo $i; ?> </a> </li>	
							<?php
							}
						}
					}
				?>
			</ul>
		</div>
	</div>
</main>

<!-- Perfil ventana modal -->
<div id="perfil" class="modal">
	<div class="modal-content">
		<h4 style="color: #26A69A;"> Perfil </h4>
		<div class="row">
			<div class="col s12">
				<p><i style="vertical-align:middle;" class="small material-icons">perm_identity</i> Usuario: <?php echo $_SESSION['usuario'] -> user; ?> </p>
				<p><i style="vertical-align:middle;" class="small material-icons">email</i> Email: <?php echo $_SESSION['usuario'] -> email; ?> </p>
			</div>
			<div class="col s12">
				<a href="#cambiarcontraseña" class="modal-close"> 
					* ¿Cambiar contraseña?
				</a>
				<p> </p>	
			</div>
			<div class="col s12">
				<a href="index.php?location=inicio&cerrarcuenta" onClick="return confirm('¿Estas seguro?');"> 
					* ¿Quieres borrar la cuenta?
				</a>
			</div>
			<div class="col s12">
				<p> </p>
				<button class="waves-effect waves-light btn modal-close">
					Aceptar
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Cambiar contraseña ventana modal -->
<div id="cambiarcontraseña" class="modal">
	<div class="modal-content">
		<h4 style="color: #26A69A;"> Perfil </h4>
		<div class="row">
			<form class="col s12" autocomplete="off" action="<?php $_SERVER['PHP_SELF'] ?>?location=inicio" method="post">
				<div class="input-field col s12">
					<input id="passwd" type="password" name="nuevapassword" />
					<label for="passwd"> Nueva contraseña </label>
					<p> </p>
				</div>
				<div class="col s3">
					<button class="waves-effect waves-light btn" type="submit" name="cambiarpassword">
						Aceptar
					</button>
				</div>
				<div class="col s3">
					<button class="waves-effect waves-light btn modal-close">
						Cancelar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>