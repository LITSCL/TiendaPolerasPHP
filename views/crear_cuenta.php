<h1>Registrarse</h1>
<?php 
if (isset($_SESSION["crear_cuenta"]) && $_SESSION["crear_cuenta"] == "Exitoso"): 
?>
	<strong class="alerta-verde">Registro realizado correctamente</strong>
<?php 
elseif (isset($_SESSION["crear_cuenta"]) && $_SESSION["crear_cuenta"] == "Fallido"): 
?>
	<strong class="alerta-roja">Error al registrarse</strong>
<?php 
endif;
?>

<?php Helper::borrarSesion("crear_cuenta"); ?>

<div class="contenedor-formulario">
	<form action="<?=BASE_URL?>controllers/UsuarioControlador.php" method="POST">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" required/>
		
		<label for="email">Email</label>
		<input type="email" name="email" required/>
		
		<label for="clave">Contraseña</label>
		<input type="password" name="clave" required/>
		
		<button type="submit" name="opcion" value="1">Registrarse</button>
	</form>
</div>