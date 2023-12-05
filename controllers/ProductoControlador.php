<?php
if (file_exists("config/parameters.php")) {
	require_once 'config/parameters.php';
}
else {
	require_once '../config/parameters.php';
}
?>

<?php
class ProductoControlador {
	
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
				case "1": //Crear.
					Helper::validarAdministrador();
					$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : false;
					$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : false;
					$precio = isset($_POST["precio"]) ? $_POST["precio"] : false;
					$stock = isset($_POST["stock"]) ? $_POST["stock"] : false;
					$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : false;
					
					$archivo = $_FILES["imagen"];
					$nombreArchivo = $archivo["name"];
					$tipoArchivo = $archivo["type"];
					
					if ($tipoArchivo == "image/jpg" || $tipoArchivo == "image/jpeg" || $tipoArchivo == "image/png") {					
						if ($nombre && $descripcion && $precio && $stock && $categoria) {
							$daoProducto = new ProductoDAO();
							$p = new Producto();
							
							if (!is_dir("../uploads/images")) {
								mkdir("../uploads/images", 0777, true);
							}
							move_uploaded_file($archivo["tmp_name"], "../uploads/images/" . $nombreArchivo);
							
							$p->setNombre($nombre);
							$p->setDescripcion($descripcion);
							$p->setPrecio($precio);
							$p->setStock($stock);
							$p->setImagen($nombreArchivo);
							$p->setCategoriaFK($categoria);
							
							if ($daoProducto->save($p)) {
								$_SESSION["crear_producto"] = "Exitoso";
							} else {
								$_SESSION["crear_producto"] = "Fallido";
							}
						}
						else {
							$_SESSION["crear_producto"] = "Fallido";
						}
					}
					else {
						$_SESSION["crear_producto"] = "Fallido";
					}
					header("Location: " . BASE_URL . "Producto/CrearProducto");
					break;
				case "2": //Eliminar.
					Helper::validarAdministrador();
					if (isset($_GET["id"])) {
						$daoProducto = new ProductoDAO();
						
						if ($daoProducto->delete($_GET["id"])) {
							$_SESSION["eliminar_producto"] = "Exitoso";
						}
						else {	
							$_SESSION["eliminar_producto"] = "Fallido";
						}
					}
					header("Location: " . BASE_URL . "Producto/MostrarProductos");
					break;
				case "3": //Modificar.
					Helper::validarAdministrador();
					$id = isset($_POST["id"]) ? $_POST["id"] : false;
					$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : false;
					$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : false;
					$precio = isset($_POST["precio"]) ? $_POST["precio"] : false;
					$stock = isset($_POST["stock"]) ? $_POST["stock"] : false;
					$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : false;
					
					$archivo = $_FILES["imagen"];
					$nombreArchivo = $archivo["name"];
					$tipoArchivo = $archivo["type"];
					
					$nuevaImagen = false;
					$imagenSubida = false;
					if ($tipoArchivo != "") {
						$nuevaImagen = true;
						if ($tipoArchivo == "image/jpg" || $tipoArchivo == "image/jpeg" || $tipoArchivo == "image/png") {
							
							if (!is_dir("../uploads/images")) {
								mkdir("../uploads/images", 0777, true);
							}
							move_uploaded_file($archivo["tmp_name"], "../uploads/images/" . $nombreArchivo);
							$imagenSubida = true;
						}
						else {
							$_SESSION["modificar_producto"] = "Fallido";
						}
					}
					
					if ($nuevaImagen == true && $imagenSubida == true || $nuevaImagen == false) {
						if ($nombre && $descripcion && $precio && $stock && $categoria) {
							$daoProducto = new ProductoDAO();
							$p = new Producto();
							
							$p->setId($id);
							$p->setNombre($nombre);
							$p->setDescripcion($descripcion);
							$p->setPrecio($precio);
							$p->setStock($stock);
							
							if ($nuevaImagen == true && $imagenSubida == true) {
								$p->setImagen($nombreArchivo);
							}
							
							$p->setCategoriaFK($categoria);
							
							if ($daoProducto->update($p)) {
								$_SESSION["modificar_producto"] = "Exitoso";
							} else {
								$_SESSION["modificar_producto"] = "Fallido";
							}
						}
						else {
							$_SESSION["modificar_producto"] = "Fallido";
						}
					}
					else {
						$_SESSION["modificar_producto"] = "Fallido";
					}
					header("Location: " . BASE_URL . "Producto/ModificarProducto&id=$id");
					break;
				default:
					return "No existe la opción";
			}
		}
		return "No se envió una opción válida para controlar";
	}
	
	public function renderizarVistaCrearProducto() {
		Helper::validarAdministrador();
		require_once 'models/dao/CategoriaDAO.php';
		
		$daoCategoria = new CategoriaDAO();
		$categorias = $daoCategoria->getAll();
		
		require_once "views/crear_producto.php";
	}
	
	public function renderizarVistaMostrarProductos() {
		Helper::validarAdministrador();
		require_once 'models/dao/ProductoDAO.php';
		
		$daoProducto = new ProductoDAO();
		$productos = $daoProducto->getAll();
		
		require_once 'views/mostrar_productos.php';
	}
	
	public function renderizarVistaMostrarProducto() {
		require_once 'models/dao/ProductoDAO.php';
		
		if (isset($_GET["id"])) {
			$daoProducto = new ProductoDAO();
			$producto = $daoProducto->find($_GET["id"]);
		}
		
		require_once 'views/mostrar_producto.php';
	}
	
	public function renderizarVistaModificarProducto() {
		Helper::validarAdministrador();
		require_once 'models/dao/ProductoDAO.php';
		require_once 'models/dao/CategoriaDAO.php';

		if (isset($_GET["id"])) {
			$daoProducto = new ProductoDAO();
			$daoCategoria = new CategoriaDAO();
			$producto = $daoProducto->find($_GET["id"]);
			$categorias = $daoCategoria->getAll();
			
			require_once 'views/modificar_producto.php';
		}
		else {
			header("Location: " . BASE_URL);
		}				
	}
	
	public function renderizarVistaAlgunosProductos() {
		require_once 'models/dao/ProductoDAO.php';
		
		$daoProducto = new ProductoDAO();
		$productos = $daoProducto->getRandom(6);
		
		require_once 'views/algunos_productos.php';
	}
	
}

if (isset($_POST["opcion"]) || isset($_GET["opcion"])) {
	session_start();
	$pc = new ProductoControlador();
	$pc->controlador();
}
?>
