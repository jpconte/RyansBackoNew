<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table_name = "usuario";
    private $tipo_usuarios_table = "tipo_usuarios";

    public $id;
    public $nombre;
    public $email;
    public $pass;
    public $tipo_usuario_id;
    public $role;
    public $token;
    public $ultimo_login;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Autenticar usuario
    public function authenticate($email, $password) {
        $query = "SELECT u.id, u.nombre, u.email, u.pass, u.tipo_usuario_id, u.role, tu.tipo_usuario 
                  FROM " . $this->table_name . " u 
                  LEFT JOIN " . $this->tipo_usuarios_table . " tu ON u.tipo_usuario_id = tu.id 
                  WHERE u.email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar contraseña
            if (password_verify($password, $row['pass'])) {
                $this->id = $row['id'];
                $this->nombre = $row['nombre'];
                $this->email = $row['email'];
                $this->tipo_usuario_id = $row['tipo_usuario_id'];
                $this->role = $row['role'];

                // Actualizar último login
                $this->updateLastLogin();

                return true;
            }
        }
        return false;
    }

    // Actualizar último login
    private function updateLastLogin() {
        $query = "UPDATE " . $this->table_name . " 
                  SET ultimo_login = NOW() 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    // Obtener usuario por ID
    public function getUserById($id) {
        $query = "SELECT u.id, u.nombre, u.email, u.tipo_usuario_id, u.role, tu.tipo_usuario 
                  FROM " . $this->table_name . " u 
                  LEFT JOIN " . $this->tipo_usuarios_table . " tu ON u.tipo_usuario_id = tu.id 
                  WHERE u.id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Verificar si el email existe
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>