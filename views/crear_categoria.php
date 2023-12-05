<h1>Crear categoría</h1>
<?php 
if (isset($_SESSION["crear_categoria"]) && $_SESSION["crear_categoria"] == "Exitoso"): 
?>
	<strong class="alerta-verde">Categoría agregada correctamente</strong>
<?php 
elseif (isset($_SESSION["crear_categoria"]) && $_SESSION["crear_categoria"] == "Fallido"): 
?>
	<strong class="alerta-roja">Error al agregar la categoría</strong>
<?php 
endif;
?>

<?php Helper::borrarSesion("crear_categoria"); ?>

<div class="contenedor-formulario">
	<form action="<?=BASE_URL?>controllers/CategoriaControlador.php" method="POST">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" required/>
		
		<button type="submit" name="opcion" value="1">Crear</button>
	</form>
</div>
