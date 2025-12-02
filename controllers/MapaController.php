<?php

class MapaController extends Controller {
    private $destinoModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->destinoModel = new Destino($db);
    }

    public function index() {
        $result = $this->destinoModel->read();
        $destinos = $result->fetchAll(PDO::FETCH_ASSOC);

        $locations = [];
        foreach ($destinos as $destino) {
            // lat and lng are already extracted by the Destino model's read() method
            // from the 'ubicacion' POINT type using ST_X() and ST_Y()
            $locations[] = [
                'lat' => (float)$destino['lat'],
                'lng' => (float)$destino['lng'],
                'nombre' => $destino['nombre'],
                'descripcion_corta' => $destino['descripcion_corta'],
                'imagen_principal' => $destino['imagen_principal'],
                'id' => $destino['id']
            ];
        }

        $data = [
            'title' => 'Mapa Interactivo - InkaTours',
            'active_page' => 'mapa',
            'locations' => json_encode($locations)
        ];
        $this->view('mapa', $data);
    }
}