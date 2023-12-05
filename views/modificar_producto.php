<h1>Modificar producto</h1>
<?php 
if (isset($_SESSION["modificar_producto"]) && $_SESSION["modificar_producto"] == "Exitoso"): 
?>
	<strong class="alerta-verde">Producto modificado correctamente</strong>
<?php 
elseif (isset($_SESSION["modificar_producto"]) && $_SESSION["modificar_producto"] == "Fallido"): 
?>
	<strong class="alerta-roja">Error al modificar el producto</strong>
<?php 
endif;
?>

<?php Helper::borrarSesion("modificar_producto"); ?>

<?php $producto = $producto->fetch_object(); ?>

<div class="contenedor-formulario">
	<form action="<?=BASE_URL?>controllers/ProductoControlador.php" method="POST" enctype="multipart/form-data">
		<label for="id">ID</label>
		<input type="text" name="id" value="<?=$producto->id?>" readonly/>
		
		<label for="nombre">Nombre</label>
		<input type="text" name="nombre" value="<?=$producto->nombre?>" required/>
		
		<label for="descripcion">Descripcion</label>
		<textarea name="descripcion"><?=$producto->descripcion?></textarea>
		
		<label for="precio">Precio</label>
		<input type="text" name="precio" value="<?=$producto->precio?>" required/>
		
		<label for="stock">Stock</label>
		<input type="number" name="stock" value="<?=$producto->stock?>" required/>
		
		<label for="categoria">Categoria</label>
		<select name="categoria">
			<?php 
			while ($categoria = $categorias->fetch_object()):
			?>
				<option value="<?=$categoria->id?>" <?=isset($producto) && is_object($producto) && $categoria->id == $producto->categoria_id ? "selected" : ""?>><?=$categoria->nombre?></option>
			<?php 
			endwhile;
			?>
		</select>
		
		<label for="imagen">Imagen</label>
		<?php 
		if (isset($producto) && is_object($producto) && !empty($producto->imagen)):
		?>
			<img class="imagen-modificar" src="<?=BASE_URL?>uploads/images/<?=$producto->imagen?>"/>
		<?php 
		endif;
		?>
		<input type="file" name="imagen"/>
		
		<button type="submit" name="opcion" value="3">Modificar</button>
	</form>
</div>