<h1>Gestionar categorías</h1>
<a class="boton boton-chico" href="<?=BASE_URL . "Categoria/CrearCategoria"?>">Crear categoría</a>

<table>
	<tr>
		<th>ID</th>
		<th>Nombre</th>
	</tr>
<?php 
while ($categoria = $categorias->fetch_object()):
?>
	<tr>
		<td><?=$categoria->id?></td>
		<td><?=$categoria->nombre?></td>
	</tr>
<?php 
endwhile;
?>
</table>