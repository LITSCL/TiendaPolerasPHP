<h1>Algunos de nuestros productos</h1>

<?php 
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
?>
