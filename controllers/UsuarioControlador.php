<?php
if (file_exists("config/parameters.php")) {
	require_once 'config/parameters.php';
}
else {
	require_once '../config/parameters.php';
}
?>

<?php
class UsuarioControlador {
    
    public function controlador() {     
        require_once '../models/dto/Usuario.php';
        require_once '../models/dao/UsuarioDAO.php';
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
                    if (isset($_POST["nombre"]) && isset($_POST["email"]) && isset($_POST["clave"])) {
                        $daoUsuario = new UsuarioDAO();
                        $u = new Usuario();
                        
                        $u->setNombre($_POST["nombre"]);
                        $u->setEmail($_POST["email"]);
                        $u->setClave($_POST["clave"]);
                        $u->setRol("Cliente");
                        
                        if ($daoUsuario->save($u)) {
                            $_SESSION["crear_cuenta"] = "Exitoso";
                        } else {
                            $_SESSION["crear_cuenta"] = "Fallido";                        
                        }
                        header("Location: " . BASE_URL . "Usuario/CrearCuenta");
                    }
                    break;                
                case "2": //Logear.
                    if (isset($_POST["email"]) && isset($_POST["clave"])) {
                        $daoUsuario = new UsuarioDAO();
                        $usuario = $daoUsuario->login($_POST["email"], $_POST["clave"]);
                        
                        if ($usuario && is_object($usuario)) {
                            $_SESSION["usuario"] = $usuario;
                        }
                        else {
                            $_SESSION["error_login"] = "Credenciales incorrectas";
                        }
                        header("Location: " . BASE_URL);
                    }
                    break;
                case "3": //Desloguear.                  
                    Helper::borrarSesion("usuario");
                    Helper::borrarSesion("carrito");
                    header("Location: " . BASE_URL);
                    break;
                default:
                    return "No existe la opción";
            }               
        }
        return "No se envió una opción válida para controlar";
    }
      
    public function renderizarVistaCrearCuenta() {
        require_once 'views/crear_cuenta.php';
    }
    
    public function renderizarVistaMostrarUsuarios() {
        require_once 'models/dao/UsuarioDAO.php'; 
        
        $daoUsuario = new UsuarioDAO();
        $usuarios = $daoUsuario->getAll();
        
        require_once 'views/mostrar_usuarios.php';
    }
    
}

if (isset($_POST["opcion"]) || isset($_GET["opcion"])) {
    session_start();
    $uc = new UsuarioControlador();
    $uc->controlador();
}
?>