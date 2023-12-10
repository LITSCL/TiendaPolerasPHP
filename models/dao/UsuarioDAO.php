<?php 
if (file_exists("config/database.php")) {
	require_once "config/database.php"; //Se usa para incluirse en el controlador frontal (Cuando se renderiza una vista).
}		
else {
	require_once "../config/database.php"; //Se usa para incluirse en el método "controlador" de los controladores del modelo.
}
?>

<?php 
class UsuarioDAO {
    public $db;
    
    public function __construct() {
        $this->db = Database::conectar(); //Cuando se crea una instancia de la capa DAO, el programa se conecta a la base de datos.
    }
    
    public function save(Usuario $u) {
        $nombre = $this->db->real_escape_string($u->getNombre());
        $email = $this->db->real_escape_string($u->getEmail());
        $clave = password_hash($this->db->real_escape_string($u->getClave()), PASSWORD_BCRYPT);
        $rol = $this->db->real_escape_string($u->getRol());
        $imagen = $this->db->real_escape_string($u->getImagen());
        
        $query = $this->db->query("INSERT INTO usuario VALUES(null, '{$nombre}', '{$email}', '{$clave}', '{$rol}', null)");
        return $query;
    }
    
    public function getAll() {
        $query = $this->db->query("SELECT * FROM usuario");
        return $query;
    }
    
    public function login($email, $clave) {
        $resultado = false;
        
        $sql = "SELECT * FROM usuario WHERE email = '{$email}'"; //1. Se busca un usuario que tenga el email entregado por parámetro.
        $login = $this->db->query($sql);
        
        if ($login && $login->num_rows == 1) { //2. Se verifica si existía un usuario con dicho email.
            $usuario = $login->fetch_object(); //3. La query se convierte en un objeto PHP (Usuario).
            $verificacion = password_verify($clave, $usuario->clave); //4. Se verifica si la clave entregada por parámetro coincide con el hash.
            
            if ($verificacion) { //5. Si la clave coincidía con el hash, se retorna el objeto (Usuario).
                $resultado = $usuario;
            }
        }
        return $resultado;
    }
    
    public function customQuery($sql) {
    	$query = $this->db->query($sql);
    	return $query;
    }
}
?>