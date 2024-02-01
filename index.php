<?php require_once "autoload.php"; ?> 
<?php require_once "config/parameters.php"; ?>
<?php require_once "helpers/Helper.php"; ?>

<?php session_start(); ?>

<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="<?=BASE_URL?>assets/css/styles.css?<?=TIME_UPDATE_CSS?>"/>
</head>
<body>
	<div id="contenedor">
    	<?php require_once "views/includes/header.php"; ?>
    	<?php require_once "views/includes/aside.php"; ?>
    	<div id="central">
        	<div id="contenido">
                <?php 
                //Para mostrar una vista en un controlador frontal, deben llegar 2 parámetros por GET, el nombre del controlador y el nombre de una función.
                if (isset($_GET["controlador"])) {
                	if (strstr($_GET["controlador"], "Controlador") == false) { //Verificando si en el valor del parámetro GET (controlador) viene concatenada la palabra "Controlador" al final.
                		$_GET["controlador"] = $_GET["controlador"] . "Controlador";
                	}
                }
                
                if (!isset($_GET["controlador"]) && !isset($_GET["accion"])) { //Verificando que el usuario se encuentre en la raíz del dominio (Si se encuentra en el dominio se carga un controlador y una acción por defecto "Hay que mostrar el index (default)").
                	$_GET["controlador"] = CONTROLLER_DEFAULT;
                	$_GET["accion"] = ACTION_DEFAULT;
                }
                
                if (isset($_GET["controlador"]) && file_exists("controllers/" . $_GET["controlador"] . ".php")) { //Verificando que llega un controlador y si el controlador existe.
                	$controlador = new $_GET["controlador"]();
                	
                	if (isset($_GET["accion"])) {
                		if (strstr($_GET["accion"], "renderizarVista") == false) { //Verificando si en el valor del parámetro GET (accion) viene concatenada la palabra "renderizarVista" al principio.
                			$_GET["accion"] = "renderizarVista" . $_GET["accion"];
                		}
                	}

                	if (isset($_GET["accion"]) && method_exists($controlador, $_GET["accion"])) { //Verificando que llega un método y si el método existe en el controlador.
                		$accion = $_GET["accion"];
                		
                		$controlador->$accion(); //Aquí se llama el método que renderiza la vista.
                	}
                	else {
                		require_once 'views/error.php';
                	}
                } else {
                	require_once 'views/error.php';
                }
                ?>
            </div>
        </div>
        <?php require_once "views/includes/footer.php"; ?>
	</div>
</body>
</html>