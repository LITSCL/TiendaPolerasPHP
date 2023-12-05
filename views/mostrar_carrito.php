<h1>Carrito de la compra</h1>
<?php 
if (isset($_SESSION["carrito"])) {
	$carrito = $_SESSION["carrito"];
}
?>

<?php 
if (isset($_SESSION["carrito"]) && count($_SESSION["carrito"]) >= 1):
?>
	<table>
		<tr>
			<th>Imagen</th>
			<th>Nombre</th>
			<th>Precio</th>
			<th>Unidades</th>
			<th>Eliminar</th>
		</tr>
	<?php 
	foreach ($carrito as $i => $elemento):
		$producto = $elemento["objeto"];
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
				<?=$elemento["unidades"]?>
				<div id="cambiarUnidades">
					<a class="boton" href="<?=BASE_URL?>controllers/CarritoControlador.php?opcion=4&indice=<?=$i?>">+</a>
					<a class="boton" href="<?=BASE_URL?>controllers/CarritoControlador.php?opcion=5&indice=<?=$i?>">-</a>
				</div>			
			</td>
			<td>
				<a class="boton boton-carrito boton-rojo" href="<?=BASE_URL?>controllers/CarritoControlador.php?opcion=2&indice=<?=$i?>">Eliminar</a>
			</td>
		</tr>
	<?php 
	endforeach;
	?>
	</table>
	
	<br/>
	
	<div id="vaciarCarrito">
	<a class="boton boton-vaciar boton-rojo" href="<?=BASE_URL?>controllers/CarritoControlador.php?opcion=3">Vaciar carrito</a>
	</div>
	
	<div id="totalCarrito">
		<h3>Precio total: $<?=Helper::obtenerEstadisticasCarrito()["total"]?></h3>
		<a class="boton boton-pedido" href="<?=BASE_URL?>Pedido/HacerPedido">Hacer pedido</a>
	</div>
<?php 
else:
?>
<p>El carrito está vacío</p>
<?php 
endif;
?>

