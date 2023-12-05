<h1>Resultado del pedido</h1>
<?php 
if (isset($_SESSION["guardar_pedido"]) && $_SESSION["guardar_pedido"] == "Exitoso"): 
?>
	<strong class="alerta-verde">Pedido realizado correctamente</strong>
	<p>
		Una vez que recibamos tu pago en la cuenta bancaria 56283715001, el pedido será procesado y despachado a tu domicilio.
	</p>
	<br/>
	<?php 
	if (isset($datosPedido)): 
		$datosPedido = $datosPedido->fetch_object();
	?>
		<h3>Datos del pedido:</h3>
		Numero de pedido: <?php print_r($datosPedido->id); ?>
		<br/>
		Total a pagar: $<?php print_r($datosPedido->coste); ?>
		<br/>
		Productos:
		<table>
			<tr>
				<th>Imagen</th>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Unidades</th>
			</tr>
		<?php 
		while ($producto = $productosPedido->fetch_object()):
		?>
		<tr>
			<td>
				<img class="imagen-carrito" src="<?=BASE_URL . 'uploads/images/' . $producto->imagen?>"/>
			</td>
			<td>
				<a href="<?=BASE_URL?>Producto/MostrarProducto&id=<?=$producto->id?>"><?=$producto->nombre?></a>
			</td>
			<td>
				<?=$producto->precio?>
			</td>
			<td>
				<?=$producto->unidades?>
			</td>
		</tr>
		<?php 
		endwhile;
		?>
		</table>
	<?php 
	endif; 
	?>
<?php 
elseif (isset($_SESSION["guardar_pedido"]) && $_SESSION["guardar_pedido"] == "Fallido"): 
?>
	<strong class="alerta-roja">Error al realizar el pedido</strong>
	<p>
		Por favor, intenta realizar el pedido mas tarde.
	</p>
<?php 
endif;
?>

<?php Helper::borrarSesion("guardar_pedido"); ?>