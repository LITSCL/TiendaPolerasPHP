<?php 
if (isset($_SESSION["usuario"])):
?>
	<h1>Hacer pedido</h1>
	<p>
		<a href="<?=BASE_URL?>/Carrito/MostrarCarrito">Ver los productos</a>
	</p>	
	
	<br/>
	
	<h3>Dirección</h3>
	<form action="<?=BASE_URL . "controllers/PedidoControlador.php"?>" method="POST">
		<label for="ciudad">Ciudad</label>
		<input type="text" name="ciudad" required/>
		
		<label for="comuna">Comuna</label>
		<input type="text" name="comuna" required/>
		
		<label for="calle">Calle</label>
		<input type="text" name="calle" required/>
		
		<button type="submit" name="opcion" value="1">Confirmar pedido</button>
	</form>
<?php 
else:
?>
	<h1>Necesitas estar logeado</h1>	
	<p>Por favor inicia sesión con tu cuenta de usuario para poder realizar la compra</p>
<?php 
endif;
?>