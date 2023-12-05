<?php
if (file_exists("config/database.php")) {
	require_once "config/database.php"; //Se usa para incluirse en el controlador frontal (Cuando se renderiza una vista).
}
else {
	require_once "../config/database.php"; //Se usa para incluirse en el m�todo "controlador" de los controladores del modelo.
}
?>

<?php 
class ProductoDAO {
    public $db;
    
    public function __construct() {
        $this->db = Database::conectar(); //Cuando se crea una instancia de la capa DAO, el programa se conecta a la base de datos.
    }
    
    public function save(Producto $p) {
        $nombre = $this->db->real_escape_string($p->getNombre());
        $descripcion = $this->db->real_escape_string($p->getDescripcion());
        $precio = $this->db->real_escape_string($p->getPrecio());
        $stock = $this->db->real_escape_string($p->getStock());
        $oferta = $this->db->real_escape_string($p->getOferta());
        $imagen = $this->db->real_escape_string($p->getImagen());
        $categoria = $this->db->real_escape_string($p->getCategoriaFK());
        
        $query = $this->db->query("INSERT INTO producto VALUES(null, '{$nombre}', '{$descripcion}', '{$precio}', '{$stock}', '{$oferta}', CURDATE(), '{$imagen}', '{$categoria}')");
        return $query;
    }
    
    public function getAll() {
        $query = $this->db->query("SELECT * FROM producto");
        return $query;
    }
    
    public function getRandom($limite) {
    	$query = $this->db->query("SELECT * FROM producto ORDER BY RAND() LIMIT {$limite}");
    	return $query;
    }
    
    public function find($id) {
    	$query = $this->db->query("SELECT * FROM producto WHERE id = {$id}");
    	return $query;
    }
    
    public function findAll($columna, $valor) {
    	$query = $this->db->query("SELECT * FROM categoria WHERE {$columna} = {$valor}");
    	return $query;
    }
    
    public function findAllFK($columnaCategoria, $columna, $valor) { //Las columnas deben ingresarse en el orden de la base de datos y deben ser opcionales, en caso de que sean falsos se le asigna un valor por defecto (La clave primaria de la tabla agena).
    	if ($columnaCategoria == false) {
    		$columnaCategoria = "id";
    	}
    	
    	$query = $this->db->query("SELECT p.*, c.nombre AS 'categoria_{$columnaCategoria}' FROM producto p INNER JOIN categoria c ON c.id = p.categoria_id WHERE p.{$columna} = {$valor}");
    	return $query;
    }
    
    public function update(Producto $p) {
    	$id = $this->db->real_escape_string($p->getId());
    	$nombre = $this->db->real_escape_string($p->getNombre());
    	$descripcion = $this->db->real_escape_string($p->getDescripcion());
    	$precio = $this->db->real_escape_string($p->getPrecio());
    	$stock = $this->db->real_escape_string($p->getStock());
    	$oferta = $this->db->real_escape_string($p->getOferta());
    	$imagen = $this->db->real_escape_string($p->getImagen());
    	$categoria = $this->db->real_escape_string($p->getCategoriaFK());
    	
    	if ($imagen == "") {
    		$query = $this->db->query("UPDATE producto SET nombre = '{$nombre}', descripcion = '{$descripcion}', precio = {$precio}, stock = {$stock}, oferta = '{$oferta}', categoria_id = {$categoria} WHERE id = {$id}");
    	}
    	else {
    		$query = $this->db->query("UPDATE producto SET nombre = '{$nombre}', descripcion = '{$descripcion}', precio = {$precio}, stock = {$stock}, oferta = '{$oferta}', imagen = '{$imagen}', categoria_id = {$categoria} WHERE id = {$id}");
    	}	
    	return $query;
    }
    
    public function delete($id) {
    	$query = $this->db->query("DELETE FROM producto WHERE id = {$id}");
    	return $query;
    }
    
    public function customQuery($sql) {
    	$query = $this->db->query($sql);
    	return $query;
    }
}
?>