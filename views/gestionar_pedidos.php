<h1>Gestionar pedidos</h1>
<table>
	<tr>
		<th>N° Pedido</th>
		<th>Coste</th>
		<th>Fecha</th>
		<th>Estado</th>
	</tr>
	<?php 
	while ($pedido = $pedidos->fetch_object()):
	?>
		<tr>
			<td><a href="<?=BASE_URL?>Pedido/DetallePedido&id=<?=$pedido->id?>"><?=$pedido->id?></a></td>
			<td>$<?=$pedido->coste?></td>
			<td><?=$pedido->fecha?></td>
			<td><?=Helper::reemplazarEstado($pedido->estado)?></td>
		</tr>
	<?php 
	endwhile;;
	?>
</table>