<?php
if (file_exists("config/parameters.php")) {
	require_once 'config/parameters.php';
}
else {
	require_once '../config/parameters.php';
}
?>

<?php
class CarritoControlador {
   
	public function controlador() {
		require_once '../models/dto/Producto.php';
		require_once '../models/dao/ProductoDAO.php';
		require_once '../helpers/Helper.php';
		
		if (isset($_POST["opcion"]) || isset($_GET["opcion"])) {
			if (isset($_POST["opcion"])) {
				$opcion = $_POST["opcion"];
			}
			else {
				$opcion = $_GET["opcion"];
			}
			switch ($opcion) {
				case "1": //Añadir.
					if (isset($_GET["id"])) {
						$productoId = $_GET["id"];
						
						if ($_SESSION["carrito"]) {
							$contador = 0;
							foreach ($_SESSION["carrito"] as $i => $elemento) {
								if ($elemento["id"] == $productoId) {
									$_SESSION["carrito"][$i]["unidades"]++;
									$contador++;
								}
							}
						}
						
						if (!isset($contador) || $contador == 0) {
							$_SESSION["carrito"];	
							$daoProducto = new ProductoDAO();
							$p = $daoProducto->find($productoId)->fetch_object();
							
							if (is_object($p)) {
								$_SESSION["carrito"][] = array("id" => $p->id, "precio" => $p->precio, "unidades" => 1, "objeto" => $p);		
							}
						}
						header("Location: " . BASE_URL . "Carrito/MostrarCarrito");
					} 
					else {
						header("Location: " . BASE_URL);
					}
					break;				
				case "2": //Remover.
					if (isset($_GET["indice"])) {
						unset($_SESSION["carrito"][$_GET["indice"]]);
					}
					header("Location: " . BASE_URL . "Carrito/MostrarCarrito");
					break;
				case "3": //Remover todos.
						Helper::borrarSesion("carrito");
						header("Location: " . BASE_URL . "Carrito/MostrarCarrito");
					break;
				case "4": //Aumentar unidad.
					if (isset($_GET["indice"])) {
						$_SESSION["carrito"][$_GET["indice"]]["unidades"]++;
					}
					header("Location: " . BASE_URL . "Carrito/MostrarCarrito");
					break;
				case "5": //Disminuir unidad.
					if (isset($_GET["indice"])) {
						$_SESSION["carrito"][$_GET["indice"]]["unidades"]--;
						
						if ($_SESSION["carrito"][$_GET["indice"]]["unidades"] == 0) {
							unset($_SESSION["carrito"][$_GET["indice"]]);
						}
					}
					header("Location: " . BASE_URL . "Carrito/MostrarCarrito");
					break;
				default:
					return "No existe la opción";
			}
		}
		return "No se envió una opción válida para controlar";
	}
	
	public function renderizarVistaMostrarCarrito() {			
		require_once 'views/mostrar_carrito.php';
	}
	
}

if (isset($_POST["opcion"]) || isset($_GET["opcion"])) {
	session_start();
	$cc = new CarritoControlador();
	$cc->controlador();
}
?>