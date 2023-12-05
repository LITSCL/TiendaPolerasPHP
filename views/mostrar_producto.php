<?php 
$producto = $producto->fetch_object();
if (isset($producto)):
?>
	<h1><?=$producto->nombre?></h1>
	<div class="producto-detalle">
		<div class="producto-imagen">
			<img src="<?=BASE_URL?>uploads/images/<?=$producto->imagen?>"/>
		</div>	
		<div class="producto-datos">
			<p class="producto-descripcion"><?=$producto->descripcion?></p>
			<p class="producto-precio">$<?=$producto->precio?></p>
			<a href="<?=BASE_URL?>controllers/CarritoControlador.php?opcion=1&id=<?=$producto->id?>" class="boton">Comprar</a>
		</div>
	</div>
<?php
else:
?>
	<h1>El producto no existe</h1>
<?php 
endif;
?>