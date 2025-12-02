<?php
class Config {
    private $conn;
    private $table = 'configuraciones';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function get_all() {
        $query = 'SELECT clave, valor FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $config = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $config[$row['clave']] = $row['valor'];
        }
        return $config;
    }

    public function update_setting($key, $value) {
        // Use an UPSERT operation (INSERT ... ON DUPLICATE KEY UPDATE)
        // This requires the 'clave' column to have a UNIQUE index.
        $query = 'INSERT INTO ' . $this->table . ' (clave, valor) 
                  VALUES (:key, :value)
                  ON DUPLICATE KEY UPDATE valor = :value';
        
        $stmt = $this->conn->prepare($query);

        $key = htmlspecialchars(strip_tags($key));
        $value = htmlspecialchars(strip_tags($value));

        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>