<?php

class HomeController extends Controller {
    private $destinoModel;
    private $blogModel;
    private $actividadModel;
    private $resenaModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->destinoModel = new Destino($db);
        $this->blogModel = new Blog($db);
        $this->actividadModel = new Actividad($db);
        $this->resenaModel = new Resena($db);
    }

    public function index() {
        // Get featured destinos
        $result_destinos = $this->destinoModel->read_featured();
        $destinos = $result_destinos->fetchAll(PDO::FETCH_ASSOC);

        // Get recent blog articles
        $result_articulos = $this->blogModel->read();
        $articulos = array_slice($result_articulos->fetchAll(PDO::FETCH_ASSOC), 0, 3);

        // Get recent reviews
        $recent_reviews = $this->resenaModel->getRecentReviews(4);

        $data = [
            'title' => 'InkaTours - Turismo Sostenible en Cusco',
            'active_page' => 'index',
            'destinos' => $destinos,
            'articulos' => $articulos,
            'recent_reviews' => $recent_reviews
        ];

        $this->view('index', $data);
    }

    public function search() {
        header('Content-Type: application/json');
        $term = isset($_GET['term']) ? $_GET['term'] . '%' : '';

        if (strlen(trim($term, '%')) < 2) {
            echo json_encode([]);
            return;
        }

        $query = "
            (SELECT id, nombre, slug, 'destino' as tipo FROM destinos WHERE nombre LIKE :term OR descripcion_corta LIKE :term)
            UNION
            (SELECT id, nombre, slug, 'actividad' as tipo FROM actividades WHERE nombre LIKE :term OR descripcion_corta LIKE :term)
            LIMIT 10
        ";

        $database = new Database();
        $db = $database->connect();
        $stmt = $db->prepare($query);
        $stmt->bindValue(':term', $term, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);
    }
}