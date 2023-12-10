<?php
if (file_exists("config/database.php")) {
	require_once "config/database.php"; //Se usa para incluirse en el controlador frontal (Cuando se renderiza una vista).
}
else {
	require_once "../config/database.php"; //Se usa para incluirse en el método "controlador" de los controladores del modelo.
}
?>

<?php 
class ProductoPedidoDAO {
    public $db;
    
    public function __construct() {
        $this->db = Database::conectar(); //Cuando se crea una instancia de la capa DAO, el programa se conecta a la base de datos.
    }
    
    public function save() { 
        $query = $this->db->query("SELECT MAX(id) AS 'id' FROM pedido");
        $pedidoId = $query->fetch_object()->id;
		
        foreach ($_SESSION["carrito"] as $i => $elemento) {
        	$producto = $elemento["objeto"];
        	$query = $this->db->query("INSERT INTO producto_pedido VALUES(null, {$pedidoId}, {$producto->id}, {$elemento['unidades']})");
        }
        return $query;
    }
    
    public function customQuery($sql) {
    	$query = $this->db->query($sql);
    	return $query;
    }
}
?>