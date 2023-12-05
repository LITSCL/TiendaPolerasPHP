<h1>Detalle del pedido</h1>

<?php 
if (isset($datosPedido)): 
	$datosPedido = $datosPedido->fetch_object();
	$pedido = $pedido->fetch_object();
?>
	<?php 
	if (Helper::verificarAdministrador() == true):
	?>
		<h3>Cambiar estado del pedido</h3>
		<form action="<?=BASE_URL?>controllers/PedidoControlador.php" method="POST">
			<input type="hidden" name="id" value="<?=$pedido->id?>"/>
			<select name="estado">
				<option value="Confirmado" <?=$pedido->estado == "Confirmado" ? "selected" : "";?>>Confirmado</option>
				<option value="Preparacion" <?=$pedido->estado == "Preparacion" ? "selected" : "";?>>En preparación</option>
				<option value="Listo" <?=$pedido->estado == "Listo" ? "selected" : "";?>>Preparado para enviar</option>
				<option value="Enviado" <?=$pedido->estado == "Enviado" ? "selected" : "";?>>Enviado</option>
			</select>
			<button type="submit" name="opcion" value="2">Cambiar</button>
		</form>
		<br/>
	<?php 
	endif;
	?>
	<h3>Detalle de envío:</h3>
	Ciudad: <?php print_r($pedido->ciudad); ?>
	<br/>
	Comuna: <?php print_r($pedido->comuna); ?>
	<br/>
	Calle: <?php print_r($pedido->calle); ?>
	
	<br/>
	<br/>
	
	<h3>Datos del pedido:</h3>
	Estado: <?php print_r(Helper::reemplazarEstado($pedido->estado)); ?>
	<br/>
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