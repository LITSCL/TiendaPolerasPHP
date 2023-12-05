<?php 
$categoria = $categoria->fetch_object();
if (isset($categoria)):
?>
	<h1><?=$categoria->nombre?></h1>
	<?php 
	if ($productos->num_rows == 0):
	?>
		<p>No hay productos para mostrar</p>
	<?php 
	else:
		while ($producto = $productos->fetch_object()):
	?>
			<div class="producto">
				<a href="<?=BASE_URL?>Producto/MostrarProducto&id=<?=$producto->id?>">
					<img src="<?=BASE_URL?>uploads/images/<?=$producto->imagen?>"/>
					<h2><?=$producto->nombre?></h2>
				</a>
				<p>$<?=$producto->precio?></p>
				<a href="<?=BASE_URL?>controllers/CarritoControlador.php?opcion=1&id=<?=$producto->id?>" class="boton">Comprar</a>
			</div>
<?php 
		endwhile; 
	endif; 
else:
?>
	<h1>La categoría no existe</h1>
<?php 
endif;
?>