<?php
if (file_exists("config/parameters.php")) {
	require_once 'config/parameters.php';
}
else {
	require_once '../config/parameters.php';
}
?>

<?php
class CategoriaControlador {
	
	public function controlador() {
		require_once '../models/dto/Categoria.php';
		require_once '../models/dao/CategoriaDAO.php';
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
					if (isset($_POST["nombre"])) {
						$daoCategoria = new CategoriaDAO();
						$c = new Categoria();
						
						$c->setNombre($_POST["nombre"]);
						
						if ($daoCategoria->save($c)) {
							$_SESSION["crear_categoria"] = "Exitoso";
						} else {
							$_SESSION["crear_categoria"] = "Fallido";
						}
						header("Location: " . BASE_URL . "Categoria/CrearCategoria");
					}
					break;
				default:
					return "No existe la opción";
			}
		}
		return "No se envió una opción válida para controlar";
	}
	
	public function renderizarVistaCrearCategoria() {
		Helper::validarAdministrador();
		require_once "views/crear_categoria.php";
	}
	
	public function renderizarVistaMostrarCategorias() {
		Helper::validarAdministrador();
		require_once 'models/dao/CategoriaDAO.php';
		
		$daoCategoria = new CategoriaDAO();
		$categorias = $daoCategoria->getAll();
		
		require_once 'views/mostrar_categorias.php';
	}
	
	public function renderizarVistaMostrarCategoria() {
		require_once 'models/dao/CategoriaDAO.php';
		require_once 'models/dao/ProductoDAO.php';

		if (isset($_GET["id"])) {
			$daoCategoria = new CategoriaDAO();
			$categoria = $daoCategoria->find($_GET["id"]);
			
			$daoProducto = new ProductoDAO();
			$productos = $daoProducto->findAllFK("nombre", "categoria_id", $_GET["id"]);
		}
		
		require_once 'views/mostrar_categoria.php';		
	}
	
}

if (isset($_POST["opcion"]) || isset($_GET["opcion"])) { 
	session_start();
	$cc = new CategoriaControlador();
	$cc->controlador();
}
?>