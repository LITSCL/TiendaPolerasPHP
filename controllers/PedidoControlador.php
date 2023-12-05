<?php
if (file_exists("config/parameters.php")) {
	require_once 'config/parameters.php';
}
else {
	require_once '../config/parameters.php';
}
?>

<?php
class PedidoControlador {
   
	public function controlador() {
		require_once '../models/dto/Pedido.php';
		require_once '../models/dao/PedidoDAO.php';
		require_once '../models/dao/ProductoPedidoDAO.php';
		require_once '../helpers/Helper.php';
		
		if (isset($_POST["opcion"]) || isset($_GET["opcion"])) {
			if (isset($_POST["opcion"])) {
				$opcion = $_POST["opcion"];
			}
			else {
				$opcion = $_GET["opcion"];
			}
			switch ($opcion) {
				case "1": //Crear.
					if (isset($_SESSION["usuario"])) {
						$ciudad = (isset($_POST["ciudad"])) ? $_POST["ciudad"] : false;
						$comuna = (isset($_POST["comuna"])) ? $_POST["comuna"] : false;
						$calle = (isset($_POST["calle"])) ? $_POST["calle"] : false;
						$coste = Helper::obtenerEstadisticasCarrito()["total"];
						$usuarioId = $_SESSION["usuario"]->id;
						
						if ($ciudad && $comuna && $calle) {
							$daoPedido = new PedidoDAO();
							$p = new Pedido();
							
							$p->setCiudad($ciudad);
							$p->setComuna($comuna);
							$p->setCalle($calle);
							$p->setCoste($coste);
							$p->setUsuarioFK($usuarioId);
							
							if ($daoPedido->save($p)) {
								$daoProductoPedido = new ProductoPedidoDAO();
								if ($daoProductoPedido->save()) {
									$_SESSION["guardar_pedido"] = "Exitoso";
								}
								else {
									$_SESSION["guardar_pedido"] = "Fallido";
								}							
							} else {
								$_SESSION["guardar_pedido"] = "Fallido";
							}						
							header("Location: " . BASE_URL . "Pedido/PedidoConfirmado");
						}
						else {
							$_SESSION["guardar_pedido"] = "Fallido";
							header("Location: " . BASE_URL);
						}
					} else {
						header("Location: " . BASE_URL);
					}
					break;
				case "2": //Cambiar Estado.
					Helper::validarAdministrador();
					if (isset($_POST["id"]) && isset($_POST["estado"])) {
						$daoPedido = new PedidoDAO();		
						$daoPedido->updateOne($_POST["id"], "estado", $_POST["estado"]);
						header("Location: " . BASE_URL . "Pedido/DetallePedido&id=" . $_POST["id"]);
					} else {
						header("Location: " . BASE_URL);
					}
					break;
				default:
					return "No existe la opción";
			}
		}
		return "No se envió una opción válida para controlar";
	}
	
	public function renderizarVistaHacerPedido() {
		require_once 'views/hacer_pedido.php';
	}
	
	public function renderizarVistaPedidoConfirmado() {
		require_once 'models/dto/Pedido.php';
		require_once 'models/dto/Producto.php';
		require_once 'models/dao/PedidoDAO.php';
		require_once 'models/dao/ProductoDAO.php';
		
		if (isset($_SESSION["usuario"])) {
			$daoPedido = new PedidoDAO();
			$daoProducto = new ProductoDAO();
			
			$sql = "SELECT p.id, p.coste FROM pedido p WHERE p.usuario_id = {$_SESSION["usuario"]->id} ORDER BY id DESC LIMIT 1";
			
			$datosPedido = $daoPedido->customQuery($sql);

			$idPedido = $daoPedido->customQuery($sql)->fetch_object()->id;
			
			$sql = "SELECT p.*, pp.unidades FROM producto p INNER JOIN producto_pedido pp ON p.id = pp.producto_id WHERE pp.pedido_id = {$idPedido}";
			
			$productosPedido = $daoProducto->customQuery($sql);
		}
		
		require_once 'views/pedido_confirmado.php';
	}
	
	public function renderizarVistaMisPedidos() {
		Helper::validarSesionIniciada();
		require_once 'models/dto/Pedido.php';
		require_once 'models/dto/Producto.php';
		require_once 'models/dao/PedidoDAO.php';
		require_once 'models/dao/ProductoDAO.php';
		
		$daoPedido = new PedidoDAO();
		
		$sql = "SELECT * FROM pedido WHERE usuario_id = {$_SESSION["usuario"]->id} ORDER BY id DESC";
		
		$pedidos = $daoPedido->customQuery($sql);
		
		require_once 'views/mis_pedidos.php';
	}
	
	public function renderizarVistaDetallePedido() {
		Helper::validarSesionIniciada();
		require_once 'models/dto/Pedido.php';
		require_once 'models/dto/Producto.php';
		require_once 'models/dao/PedidoDAO.php';
		require_once 'models/dao/ProductoDAO.php';
		
		if (!isset($_GET["id"])) {
			header("Location: " . BASE_URL . "Pedido/MisPedidos");
		}
		
		$daoPedido = new PedidoDAO();
		$daoProducto = new ProductoDAO();
		
		$idPedido = $_GET["id"];
		$pedido = $daoPedido->find($idPedido);
		
		$sql = "SELECT p.id, p.coste FROM pedido p WHERE p.usuario_id = {$_SESSION["usuario"]->id} ORDER BY id DESC LIMIT 1";
		
		$datosPedido = $daoPedido->customQuery($sql);
		$idPedido = $daoPedido->customQuery($sql)->fetch_object()->id;
		
		$sql = "SELECT p.*, pp.unidades FROM producto p INNER JOIN producto_pedido pp ON p.id = pp.producto_id WHERE pp.pedido_id = {$idPedido}";
		
		$productosPedido = $daoProducto->customQuery($sql);
		
		require_once 'views/detalle_pedido.php';
	}
	
	public function renderizarVistaGestionarPedidos() {
		Helper::validarAdministrador();
		require_once 'models/dto/Pedido.php';
		require_once 'models/dao/PedidoDAO.php';
		
		$daoPedido = new PedidoDAO();
		$pedidos = $daoPedido->getAll();
		
		require_once 'views/gestionar_pedidos.php';
	}
	
}

if (isset($_POST["opcion"]) || isset($_GET["opcion"])) {
	session_start();
	$pc = new PedidoControlador();
	$pc->controlador();
}
?>