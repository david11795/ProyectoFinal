<header>
	<nav>
		<div class="nav-wrapper">
			<a href="index.php" class="brand-logo left">ShortUrl</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><a href="#login">Iniciar sesion</a></li>			
				<li><a href="#registro">Registro</a></li>
			</ul>
		</div>
	</nav>
</header>
<div id="particles-js"></div>
<main>
    <div class="container" style="height:100%;">
		<div class="row centrar2">
			<div class="col s12 enlaces">
				<h2 class="center"> ShortUrl </h2>
				<h4 class="center enlaces1"> Acorta tu url rapidamente y sin publicidad. </h4>
			</div>
		</div>
		<div class="row centrar">
			<form class="col s12" autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="input-field col s7 m10 fondoInput">
					<input id="url" type="text" name="url">
					<label for="url">Introduce url</label>
				</div>
				<div class="input-field col s3 m2">
					<button class="waves-effect waves-light btn buttonInput" type="submit" name="turl">
						ACORTAR
					</button>
				</div>
			</form>
		</div>
        <div class="row centrar">
             <div class="col s12 center">
				<?php
					if(isset($_POST['turl']) && !empty(trim($_POST['url'])) && !filter_var($_POST['url'], FILTER_VALIDATE_URL) === false){
						$busqueda = Url::buscar($_POST['url']);
						if($busqueda == null){
							Url::createHash($_POST['url']);	
							$busqueda = Url::buscar($_POST['url']);
							$shorturlnueva = $busqueda[0] -> shorturl;
							echo "<h3 class='responsive-h3'><a class='enlaces' href=".$shorturlnueva." target='_blank' >".$_SERVER['SERVER_NAME']."/".$shorturlnueva." </a> </h3>";					
						}else {
							echo "<h3 class='responsive-h3'><a class='enlaces' href=".$busqueda[0] -> shorturl." target='_blank' >".$_SERVER['SERVER_NAME']."/".$busqueda[0] -> shorturl." </a> </h3>";
						}
						unset($_POST['url']);
						unset($_POST['turl']);
					}
				?>
			</div>
        </div>
    </div>
</main>

<!-- Login ventana modal -->
<div id="login" class="modal">
	<div class="modal-content">
		<h4 style="color: #26A69A;">Iniciar sesion</h4>
		<div class="row">
			<form class="col s12" autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?location=inicio">
				<div class="input-field col s6">
					<input id="usuario" type="text" name="usuario">
					<label for="Usuario">Usuario</label>
				</div>
				<div class="input-field col s6">
					<input id="password" type="password" name="password">
					<label for="password">Password</label>
				</div>
				<div class="input-field col s12">
					<a href="#passwd" class="modal-close" > * ¿Has olvidado la contraseña? </a>
				</div>
				<div class="input-field col s4">
					<button class="waves-effect waves-light btn" type="submit" name="enviar">
						Aceptar
					</button>
				</div>
				<div class="input-field col s3">
					<button class="waves-effect waves-light btn modal-close">
						Cancelar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Recuperar password ventana modal -->
<div id="passwd" class="modal">
	<div class="modal-content">
		<h4 style="color: #26A69A;">Recuperar contraseña</h4>
		<div class="row">
			<form class="col s12" autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?location=login">
				<div class="input-field col s6">
					<input id="emailPasswd" type="email" name="emailPasswd">
					<label for="emailPasswd">Email</label>
				</div>
				<div class="input-field col s6">
					<input id="nuevaPasswd" type="password" name="nuevaPasswd">
					<label for="nuevaPasswd">Nueva contraseña</label>
				</div>
				<div class="input-field col s4">
					<button class="waves-effect waves-light btn" type="submit" name="recuperar">
						Aceptar
					</button>
				</div>
				<div class="input-field col s3">
					<button class="waves-effect waves-light btn modal-close">
						Cancelar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

	
<!-- Registro ventana modal -->
<div id="registro" class="modal">
	<div class="modal-content">
		<h4 style="color: #26A69A;">Registro</h4>
		<div class="row">
			<form class="col s12" autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?location=login">
				<div class="row">
					<div class="input-field col s4">
						<input id="usuario" type="text" name="usuarioRegistro">
						<label for="Usuario">Usuario</label>
					</div>
					<div class="input-field col s4">
						<input id="email" type="email" name="emailRegistro">
						<label for="email">Email</label>
					</div>
					<div class="input-field col s4">
						<input id="password" type="password" name="passwordRegistro">
						<label for="password">Password</label>
					</div>
				</div>
				<div class="input-field col s3">
					<button class="waves-effect waves-light btn" type="submit" name="tregistro">
						Registrarse
					</button>
				</div>
				<div class="input-field col s3">
					<button class="waves-effect waves-light btn modal-close">
						Cancelar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

