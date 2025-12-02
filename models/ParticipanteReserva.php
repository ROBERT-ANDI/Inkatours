<?php

class ParticipanteReserva {
    private $conn;
    private $table = 'participantes_reserva';

    public $id;
    public $reserva_id;
    public $nombre;
    public $email;
    public $telefono;
    public $fecha_nacimiento;
    public $documento_identidad;
    public $tipo_documento;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
            SET
                reserva_id = :reserva_id,
                nombre = :nombre,
                email = :email,
                telefono = :telefono';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->reserva_id = htmlspecialchars(strip_tags($this->reserva_id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));

        // Bind data
        $stmt->bindParam(':reserva_id', $this->reserva_id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefono', $this->telefono);

        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}

