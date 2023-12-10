<?php
if (file_exists("config/database.php")) {
	require_once "config/database.php"; //Se usa para incluirse en el controlador frontal (Cuando se renderiza una vista).
}
else {
	require_once "../config/database.php"; //Se usa para incluirse en el método "controlador" de los controladores del modelo.
}
?>

<?php 
class PedidoDAO {
    public $db;
    
    public function __construct() {
        $this->db = Database::conectar(); //Cuando se crea una instancia de la capa DAO, el programa se conecta a la base de datos.
    }
    
    public function getAll() {
    	$query = $this->db->query("SELECT * FROM pedido");
    	return $query;
    }
    
    public function save(Pedido $p) {
    	$ciudad = $this->db->real_escape_string($p->getCiudad());
    	$comuna = $this->db->real_escape_string($p->getComuna());
    	$calle = $this->db->real_escape_string($p->getCalle());
    	$coste = $this->db->real_escape_string($p->getCoste());
    	$usuarioId = $this->db->real_escape_string($p->getUsuarioFK());
        
        $query = $this->db->query("INSERT INTO pedido VALUES(null, '$ciudad', '$comuna', '$calle', $coste, 'Confirmado', CURDATE(), CURTIME(), $usuarioId )");
        return $query;
    }
    
    public function find($id) {
    	$query = $this->db->query("SELECT * FROM pedido WHERE id = $id");
    	return $query;
    }
    
    public function findAll($columna, $valor) {
    	$query = $this->db->query("SELECT * FROM producto WHERE $columna = '$valor'");
    	return $query;
    }
    
    public function updateOne($id, $columna, $valor) {
    	$valor = $this->db->real_escape_string($valor);
    	$query = $this->db->query("UPDATE pedido SET {$columna} = '{$valor}' WHERE id = {$id}");
    	return $query;
    }
    
    public function customQuery($sql) {
    	$query = $this->db->query($sql);
    	return $query;
    }
}
?>