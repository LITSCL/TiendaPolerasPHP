<!-- Barra lateral. -->
<aside id="lateral">
<div id="login" class="bloque-lateral">
	<div id="carrito" class="bloque-lateral">
		<h3>Mi carrito</h3>
		<ul>
			<li><a href="<?=BASE_URL?>Carrito/MostrarCarrito">Productos (<?=Helper::obtenerEstadisticasCarrito()["cantidad"]?>)</a></li>
			<li><a href="<?=BASE_URL?>Carrito/MostrarCarrito">Total: $<?=Helper::obtenerEstadisticasCarrito()["total"]?></a></li>
			<li><a href="<?=BASE_URL?>Carrito/MostrarCarrito">Ver el carrito</a></li>
		</ul>
	</div>
	<?php 
	if (!isset($_SESSION["usuario"])): 
	?>
		<h3>Entrar a la web</h3>
		<form action="<?=BASE_URL?>controllers/UsuarioControlador.php" method="POST">
			<label for="email">Email</label> <input type="email" name="email" />

			<label for="clave">Contraseña</label> 
			<input type="password"name="clave" /> 
				
			<button type="submit" name="opcion" value="2">Login</button>
		</form>
	<?php 
	else:
	?>
		<h3><?=$_SESSION["usuario"]->nombre?></h3>
	<?php 
	endif;
	?>
		<ul>
		<?php 
		if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]->rol == "Cliente"):
		?>
			<li><a href="<?=BASE_URL?>Pedido/MisPedidos">Mis pedidos</a></li>	
		<?php 
		endif;
		?>
		
		<?php 
		if (isset($_SESSION["usuario"]) && $_SESSION["usuario"]->rol == "Administrador"):
		?>
			<li><a href="<?=BASE_URL?>Categoria/MostrarCategorias">Gestionar categorías</a></li>
			<li><a href="<?=BASE_URL?>Producto/MostrarProductos">Gestionar productos</a></li>
			<li><a href="<?=BASE_URL?>Pedido/GestionarPedidos">Gestionar pedidos</a></li>
			<li><a href="<?=BASE_URL?>Pedido/MisPedidos">Mis pedidos</a></li>	
		<?php 
		endif;
		?>
		
		<?php 
		if (isset($_SESSION["usuario"])):
		?>
			<li><a href="<?=BASE_URL?>controllers/UsuarioControlador.php?opcion=3">Cerrar sesión</a></li>	
		<?php 
		else:
		?>	
			<li><a href="<?=BASE_URL?>Usuario/CrearCuenta">Crear cuenta</a></li>
		<?php 
		endif;
		?>
		</ul>
	</div>
</aside>