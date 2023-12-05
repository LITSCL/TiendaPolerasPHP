<h1>Gestionar productos</h1>
<a class="boton boton-chico" href="<?=BASE_URL . "Producto/CrearProducto"?>">Crear producto</a>

<?php 
if (isset($_SESSION["eliminar_producto"]) && $_SESSION["eliminar_producto"] == "Exitoso"): 
?>
	<strong class="alerta-verde">Producto eliminado correctamente</strong>
<?php 
elseif (isset($_SESSION["eliminar_producto"]) && $_SESSION["eliminar_producto"] == "Fallido"): 
?>
	<strong class="alerta-roja">Error al eliminar el producto</strong>
<?php 
endif;
?>

<?php Helper::borrarSesion("eliminar_producto"); ?>

<table>
	<tr>
		<th>ID</th>
		<th>Nombre</th>
		<th>Precio</th>
		<th>Stock</th>
		<th>Acciones</th>
	</tr>
<?php 
while ($producto = $productos->fetch_object()):
?>
	<tr>
		<td><?=$producto->id?></td>
		<td><?=$producto->nombre?></td>
		<td><?=$producto->precio?></td>
		<td><?=$producto->stock?></td>
		<td>
			<a href="<?=BASE_URL?>Producto/ModificarProducto&id=<?=$producto->id?>" class="boton boton-accion boton-amarillo">Modificar</a>
			<a href="<?=BASE_URL?>controllers/ProductoControlador.php?opcion=2&id=<?=$producto->id?>" class="boton boton-accion boton-rojo">Eliminar</a>
		</td>
	</tr>
<?php 
endwhile;
?>
</table>
