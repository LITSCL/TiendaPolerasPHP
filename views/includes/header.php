<?php require_once "models/dao/CategoriaDAO.php"; ?>

<?php 
$daoCategoria = new CategoriaDAO();
$categorias = $daoCategoria->getAll();
?>

<!-- Cabecera. -->
<header>
	<div id="logo">
		<img src="<?=BASE_URL?>assets/img/camiseta.png" alt="Logo"/> <a href="index.php">Tienda de camisetas</a>
	</div>
</header>

<!-- Menu. -->
<nav>
	<ul>
		<li><a href="<?=BASE_URL?>">Inicio</a></li>
	<?php 
	while ($categoria = $categorias->fetch_object()):
	?>
		<li><a href="<?=BASE_URL?>Categoria/MostrarCategoria&id=<?=$categoria->id?>"><?=$categoria->nombre?></a></li>
	<?php 
	endwhile;
	?>
	</ul>
</nav>