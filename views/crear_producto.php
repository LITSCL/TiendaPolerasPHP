<h1>Crear producto</h1>
<?php 
if (isset($_SESSION["crear_producto"]) && $_SESSION["crear_producto"] == "Exitoso"): 
?>
	<strong class="alerta-verde">Producto agregado correctamente</strong>
<?php 
elseif (isset($_SESSION["crear_producto"]) && $_SESSION["crear_producto"] == "Fallido"): 
?>
	<strong class="alerta-roja">Error al agregar el producto</strong>
<?php 
endif;
?>

<?php Helper::borrarSesion("crear_producto"); ?>

<div class="contenedor-formulario">
	<form action="<?=BASE_URL?>controllers/ProductoControlador.php" method="POST" enctype="multipart/form-data">
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" required/>
		
		<label for="descripcion">Descripcion</label>
		<textarea name="descripcion"></textarea>
		
		<label for="precio">Precio</label>
		<input type="text" name="precio" required/>
		
		<label for="stock">Stock</label>
		<input type="number" name="stock" required/>
		
		<label for="categoria">Categoria</label>
		<select name="categoria">
			<?php 
			while ($categoria = $categorias->fetch_object()):
			?>
				<option value="<?=$categoria->id?>"><?=$categoria->nombre?></option>
			<?php 
			endwhile;
			?>
		</select>
		
		<label for="imagen">Imagen</label>
		<input type="file" name="imagen" required/>
		
		<button type="submit" name="opcion" value="1">Crear</button>
	</form>
</div>