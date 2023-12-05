<?php
class Helper {
    
    public static function borrarSesion($nombre) {
        if (isset($_SESSION[$nombre])) {
            unset($_SESSION[$nombre]);
        }
    }
    
    public static function validarAdministrador() {
    	if (isset($_SESSION["usuario"])) {
    		if ($_SESSION["usuario"]->rol != "Administrador") {
    			header("Location: " . BASE_URL);
    		}
    		else {
    			return true;
    		}
    	}
    	else {
    		header("Location: " . BASE_URL);
    	}
    }
    
    public static function validarSesionIniciada() {
    	if (!isset($_SESSION["usuario"])) {
    		header("Location: " . BASE_URL);
    	}
    }
    
    public static function obtenerEstadisticasCarrito() {
    	$estadisticas = array("cantidad" => 0, "total" => 0);
    	if (isset($_SESSION["carrito"])) {
    		$estadisticas["cantidad"] = count($_SESSION["carrito"]);
    		
    		foreach ($_SESSION["carrito"] as $elemento) {
    			$estadisticas["total"]+=$elemento["precio"] * $elemento["unidades"];
    		}
    	}
    	return $estadisticas;
    }
    
    public static function reemplazarEstado($estado) {
    	switch ($estado) {
    		case "Confirmado":
    			return "Confirmado";
    			break;
    		case "Preparacion":
    			return "En preparación";
    			break;
    		case "Listo":
    			return "Preparado para enviar";
    			break;
    		case "Enviado":
    			return "Enviado";
    			break;
    		default:
    			return "Error Fatal";
    	}
    }
    
}
?>