<?php

class AdminController extends Controller {

    private $db;
    private $userModel;
    private $resenaModel;
    private $destinoModel;
    private $actividadModel;
    private $blogModel;
    private $configModel;
    private $dashboardModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new User($this->db);
        $this->resenaModel = new Resena($this->db);
        $this->destinoModel = new Destino($this->db);
        $this->actividadModel = new Actividad($this->db);
        $this->blogModel = new Blog($this->db);
        $this->configModel = new Config($this->db);
        $this->dashboardModel = new DashboardModel($this->db);
    }

    // Admin dashboard - lists reviews for moderation
    public function dashboard() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $reviews = $this->resenaModel->getAllReviews();

        $data = [
            'title' => 'Admin Dashboard - InkaTours',
            'reviews' => $reviews,
            'active_page' => 'dashboard'
        ];

        $this->view('admin/dashboard', $data);
    }
    
    //=============== DESTINOS ===============//

    public function destinos() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $stmt = $this->destinoModel->read();
        $destinos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Gestión de Destinos - InkaTours',
            'destinos' => $destinos,
            'active_page' => 'destinos'
        ];

        $this->view('admin/destinos', $data);
    }
    
    public function destino_form() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $data = [
            'title' => 'Formulario de Destino - InkaTours',
            'active_page' => 'destinos'
        ];

        $this->view('admin/destino_form', $data);
    }

    public function create_destino() {
        if (!$this->isAdminLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /mi%20proyecto/admin/destinos');
            exit;
        }

        $upload_dir = 'static/img/destinos/';
        $new_filename = '';

        // Handle file upload
        if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] == 0) {
            $file = $_FILES['imagen_principal'];

            // 1. Validate file type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($file['tmp_name']);
            if ($mime_type !== 'image/png') {
                header('Location: /mi%20proyecto/admin/destino_form?error=InvalidFileType');
                exit;
            }

            // 2. Validate file size (e.g., max 2MB)
            if ($file['size'] > 2 * 1024 * 1024) {
                header('Location: /mi%20proyecto/admin/destino_form?error=FileSizeTooLarge');
                exit;
            }
            
            // 3. Generate unique name and move file
            $new_filename = 'destino_' . time() . '.png';
            $target_path = $upload_dir . $new_filename;

            if (!move_uploaded_file($file['tmp_name'], $target_path)) {
                header('Location: /mi%20proyecto/admin/destino_form?error=UploadFailed');
                exit;
            }
        } else {
            header('Location: /mi%20proyecto/admin/destino_form?error=NoFileUploaded');
            exit;
        }

        $data = $_POST;
        $data['imagen_principal'] = $new_filename;

        if ($this->destinoModel->create($data)) {
            header('Location: /mi%20proyecto/admin/destinos');
            exit;
        } else {
            // Optional: Delete uploaded file if DB insertion fails
            if (file_exists($target_path)) {
                unlink($target_path);
            }
            header('Location: /mi%20proyecto/admin/destino_form?error=DBCreateFailed');
            exit;
        }
    }
    
    //=============== ACTIVIDADES ===============//

    public function actividades() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $stmt = $this->actividadModel->read();
        $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Gestión de Actividades - InkaTours',
            'actividades' => $actividades,
            'active_page' => 'actividades'
        ];

        $this->view('admin/actividades', $data);
    }

    public function actividad_form() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $data = [
            'title' => 'Formulario de Actividad - InkaTours',
            'active_page' => 'actividades'
        ];

        $this->view('admin/actividad_form', $data);
    }

    public function create_actividad() {
        if (!$this->isAdminLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /mi%20proyecto/admin/actividades');
            exit;
        }

        if ($this->actividadModel->create($_POST)) {
            header('Location: /mi%20proyecto/admin/actividades');
            exit;
        } else {
            header('Location: /mi%20proyecto/admin/actividad_form?error=1');
            exit;
        }
    }

    //=============== BLOG ===============//

    public function blog() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $stmt = $this->blogModel->read();
        $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Gestión de Blog - InkaTours',
            'articulos' => $articulos,
            'active_page' => 'blog'
        ];

        $this->view('admin/blog', $data);
    }

    public function blog_approve($id) {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $this->blogModel->id = $id;
        if ($this->blogModel->approve()) {
            // Success
        }
        header('Location: /mi%20proyecto/admin/blog');
        exit;
    }

    public function blog_disapprove($id) {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $this->blogModel->id = $id;
        if ($this->blogModel->disapprove()) {
            // Success
        }
        header('Location: /mi%20proyecto/admin/blog');
        exit;
    }

    public function blog_delete($id) {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $this->blogModel->id = $id;
        if ($this->blogModel->delete()) {
            // Success
        }
        header('Location: /mi%20proyecto/admin/blog');
        exit;
    }

    public function blog_form() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $data = [
            'title' => 'Formulario de Artículo - InkaTours',
            'active_page' => 'blog'
        ];

        $this->view('admin/blog_form', $data);
    }

    public function create_blog() {
        if (!$this->isAdminLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /mi%20proyecto/admin/blog');
            exit;
        }

        $upload_dir = 'static/img/blog/';
        $new_filename = '';

        if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] == 0) {
            $file = $_FILES['imagen_principal'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($file['tmp_name']);

            if ($mime_type === 'image/png') {
                if ($file['size'] <= 2 * 1024 * 1024) {
                    $new_filename = 'blog_' . time() . '.png';
                    $target_path = $upload_dir . $new_filename;

                    if (move_uploaded_file($file['tmp_name'], $target_path)) {
                        $data = $_POST;
                        $data['imagen_principal'] = $new_filename;

                        if ($this->blogModel->create($data)) {
                            header('Location: /mi%20proyecto/admin/blog');
                            exit;
                        } else {
                            if (file_exists($target_path)) {
                                unlink($target_path);
                            }
                            header('Location: /mi%20proyecto/admin/blog_form?error=DBCreateFailed');
                            exit;
                        }
                    } else {
                        header('Location: /mi%20proyecto/admin/blog_form?error=UploadFailed');
                        exit;
                    }
                } else {
                    header('Location: /mi%20proyecto/admin/blog_form?error=FileSizeTooLarge');
                    exit;
                }
            } else {
                header('Location: /mi%20proyecto/admin/blog_form?error=InvalidFileType');
                exit;
            }
        } else {
            $data = $_POST;
            $data['imagen_principal'] = 'default.png'; // Asignar imagen por defecto

            if ($this->blogModel->create($data)) {
                header('Location: /mi%20proyecto/admin/blog');
                exit;
            } else {
                header('Location: /mi%20proyecto/admin/blog_form?error=DBCreateFailed');
                exit;
            }
        }
    }

    public function blog_edit($id = null) {
        if (!$this->isAdminLoggedIn()) { header('Location: /mi%20proyecto/iniciosesion'); exit; }
        if (!$id) { header('Location: /mi%20proyecto/admin/blog'); exit; }

        $this->blogModel->id = $id;
        $this->blogModel->read_single();

        $data = [
            'title' => 'Editar Artículo',
            'articulo' => (array)$this->blogModel,
            'active_page' => 'blog'
        ];
        $this->view('admin/blog_form', $data);
    }

    public function blog_guardar() {
        if (!$this->isAdminLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /mi%20proyecto/admin/blog');
            exit;
        }

        $id = $_POST['id'];
        $datos = $_POST;

        if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] == 0) {
            $upload_dir = 'static/img/blog/';
            $file = $_FILES['imagen_principal'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($file['tmp_name']);

            if ($mime_type === 'image/png' && $file['size'] <= 2 * 1024 * 1024) {
                $new_filename = 'blog_' . time() . '.png';
                $target_path = $upload_dir . $new_filename;

                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    $datos['imagen_principal'] = $new_filename;
                }
            }
        }

        $this->blogModel->update($id, $datos);
        header('Location: /mi%20proyecto/admin/blog');
        exit;
    }



    //=============== RESEÑAS ===============//

    public function approve($id) {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        if ($this->resenaModel->approve($id)) {
            // Success
        }
        header('Location: /mi%20proyecto/admin/dashboard');
        exit;
    }

    public function reject($id) {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        if ($this->resenaModel->reject($id)) {
            // Success
        }
        header('Location: /mi%20proyecto/admin/dashboard');
        exit;
    }

    public function disapprove_review($id) {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        if ($this->resenaModel->disapprove($id)) {
            // Success
        }
        header('Location: /mi%20proyecto/admin/dashboard');
        exit;
    }

    //=============== GENERAL ===============//

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_rol']);
        header('Location: /mi%20proyecto/');
        exit;
    }
    
    private function isAdminLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']) && $_SESSION['user_rol'] === 'admin';
    }

    // --- Gestión de Destinos (Versión Corregida Final) ---

    public function destino_editar($id = null) {
        if (!$this->isAdminLoggedIn()) { header('Location: /mi%20proyecto/iniciosesion'); exit; }
        if (!$id) { header('Location: /mi%20proyecto/admin/destinos'); exit; }

        $this->destinoModel->id = $id;
        $this->destinoModel->read_single(); // Carga los datos en el objeto

        $data = [ 
            'title' => 'Editar Destino', 
            'destino' => (array)$this->destinoModel, // Convertimos el objeto a array para la vista
            'active_page' => 'destinos' 
        ];
        $this->view('admin/destino_form', $data);
    }

    public function destino_guardar() {
        if (!$this->isAdminLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /mi%20proyecto/admin/destinos'); exit; }
        
        $id = $_POST['id'];
        $datos = [ 'nombre' => $_POST['nombre'], 'descripcion' => $_POST['descripcion'] ];

        $this->destinoModel->update($id, $datos);
        header('Location: /mi%20proyecto/admin/destinos'); exit;
    }

    public function destino_eliminar($id = null) {
        if (!$this->isAdminLoggedIn()) { header('Location: /mi%20proyecto/iniciosesion'); exit; }
        if ($id) {
            $this->destinoModel->delete($id);
        }
        header('Location: /mi%20proyecto/admin/destinos'); exit;
    }

    public function destino_destacar($id = null) {
        if (!$this->isAdminLoggedIn()) { header('Location: /mi%20proyecto/iniciosesion'); exit; }
        
        if ($id) {
            $count = $this->destinoModel->count_featured();
            if ($count >= 6) {
                header('Location: /mi%20proyecto/admin/destinos?error=max_featured');
                exit;
            }
            $this->destinoModel->toggleDestacado($id, 1);
        }
        header('Location: /mi%20proyecto/admin/destinos'); exit;
    }

    public function destino_no_destacar($id = null) {
        if (!$this->isAdminLoggedIn()) { header('Location: /mi%20proyecto/iniciosesion'); exit; }
        if ($id) {
            $this->destinoModel->toggleDestacado($id, 0);
        }
        header('Location: /mi%20proyecto/admin/destinos'); exit;
    }

    // --- Gestión de Actividades (Versión Corregida Final) ---

    public function actividad_editar($id = null) {
        if (!$this->isAdminLoggedIn()) { header('Location: /mi%20proyecto/iniciosesion'); exit; }
        if (!$id) { header('Location: /mi%20proyecto/admin/actividades'); exit; }

        // Asumiendo que Actividad.php tiene la misma estructura que Destino.php
        $this->actividadModel->id = $id;
        $this->actividadModel->read_single();

        $data = [ 
            'title' => 'Editar Actividad', 
            'actividad' => (array)$this->actividadModel, 
            'active_page' => 'actividades' 
        ];
        $this->view('admin/actividad_form', $data);
    }

    public function actividad_guardar() {
        if (!$this->isAdminLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /mi%20proyecto/admin/actividades'); exit; }

        $id = $_POST['id'];
        $datos = [ 'nombre' => $_POST['nombre'], 'descripcion' => $_POST['descripcion'] ];
        
        // Asumiendo que Actividad.php también tendrá un método update
        $this->actividadModel->update($id, $datos);
        header('Location: /mi%20proyecto/admin/actividades'); exit;
    }

    public function actividad_eliminar($id = null) {
        if (!$this->isAdminLoggedIn()) { header('Location: /mi%20proyecto/iniciosesion'); exit; }
        if ($id) {
            // Asumiendo que Actividad.php también tendrá un método delete
            $this->actividadModel->delete($id);
        }
        header('Location: /mi%20proyecto/admin/actividades'); exit;
    }

    //=============== CONFIGURACIÓN ===============//

    public function configuracion() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        $configs = $this->configModel->get_all();

        $data = [
            'title' => 'Configuración de la Empresa - InkaTours',
            'config' => $configs,
            'active_page' => 'configuracion'
        ];

        $this->view('admin/configuracion_form', $data);
    }

    public function guardar_configuracion() {
        if (!$this->isAdminLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /mi%20proyecto/admin/configuracion');
            exit;
        }

        $settings = $_POST;
        foreach ($settings as $key => $value) {
            $this->configModel->update_setting($key, $value);
        }

        header('Location: /mi%20proyecto/admin/configuracion?success=1');
        exit;
    }

    //=============== DASHBOARD DE AFLUENCIA ===============//

    public function afluencia() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }

        // 1. Afluencia Actual por Reservas
        $afluencia_actual = $this->dashboardModel->getAfluenciaActual();

        // 2. Predicción de Afluencia
        $predicciones = $this->dashboardModel->getPrediccionesRecientes();

        // 3. Datos para el Mapa
        $map_data = $this->dashboardModel->getDestinosConAfluenciaActual();

        $data = [
            'title' => 'Dashboard de Afluencia Turística - InkaTours',
            'active_page' => 'afluencia',
            'afluencia_actual' => $afluencia_actual,
            'predicciones' => $predicciones,
            'map_data_json' => json_encode($map_data)
        ];

        $this->view('admin/dashboard_afluencia', $data);
    }

    public function predicciones() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit;
        }
        
        // This data structure is a placeholder for the complex backend logic
        // that would be needed to generate these analytics in a real application.
        $data = [
            'title' => 'Dashboard de Inteligencia Turística - InkaTours',
            'active_page' => 'predicciones',
            'kpis' => [
                'total_visitantes' => 1250,
                'tendencia_visitantes' => 5,
                'sitios_criticos' => 2,
                'capacidad_disponible' => 65,
                'indice_sostenibilidad' => 8.2
            ],
            'destinos' => [
                ['nombre' => 'Machu Picchu', 'afluencia' => 92, 'capacidad' => 2500, 'recomendacion' => 'Visitar en horarios de baja afluencia.', 'nivel_clase' => 'critical'],
                ['nombre' => 'Montaña 7 Colores', 'afluencia' => 75, 'capacidad' => 500, 'recomendacion' => 'Se recomienda buena aclimatación.', 'nivel_clase' => 'high'],
                ['nombre' => 'Valle Sagrado', 'afluencia' => 55, 'capacidad' => 1500, 'recomendacion' => 'Ideal para visitas de día completo.', 'nivel_clase' => 'medium'],
                ['nombre' => 'Camino Inca', 'afluencia' => 100, 'capacidad' => 500, 'recomendacion' => 'Permisos agotados.', 'nivel_clase' => 'critical'],
                ['nombre' => 'Laguna Humantay', 'afluencia' => 65, 'capacidad' => 300, 'recomendacion' => 'Llevar ropa abrigadora.', 'nivel_clase' => 'high'],
                ['nombre' => 'Salineras de Maras', 'afluencia' => 40, 'capacidad' => 200, 'recomendacion' => 'Excelente para fotografía.', 'nivel_clase' => 'medium'],
            ],
            'destino_focus' => 'Machu Picchu',
            'alertas' => [
                ['nivel' => 'critica', 'titulo' => 'Alerta de Capacidad: Camino Inca', 'descripcion' => 'Permisos para el Camino Inca están al 100% para los próximos 15 días.', 'timestamp' => 'Hace 15 minutos'],
                ['nivel' => 'advertencia', 'titulo' => 'Afluencia Alta en Machu Picchu', 'descripcion' => 'Se espera que la afluencia supere el 90% entre las 10:00 y las 14:00.', 'timestamp' => 'Hace 1 hora'],
            ],
            'reservas' => [
                ['destino' => 'Machu Picchu', 'fecha' => '2025-12-10', 'grupos' => 15, 'personas' => 120, 'estado' => 'confirmada'],
                ['destino' => 'Valle Sagrado', 'fecha' => '2025-12-10', 'grupos' => 8, 'personas' => 60, 'estado' => 'pagada'],
            ],
            'recomendaciones' => [
                ['tipo' => 'distribucion', 'titulo' => 'Distribuir visitantes de Machu Picchu', 'descripcion' => 'Promocionar Piquillacta y Tipón como alternativas.', 'impacto' => 85],
                ['tipo' => 'horario', 'titulo' => 'Extender Horarios en Valle Sagrado', 'descripcion' => 'Abrir Ollantaytambo hasta las 19:00.', 'impacto' => 60],
            ],
            'tendencias' => [
                'machu_picchu_tendencia' => 7.5,
                'vinicunca_tendencia' => 12.2,
                'comunitario_tendencia' => 4.8,
            ],
            // Data for JS charts
            'hourly_prediction' => [
                'labels' => ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00'],
                'prediction' => [15, 45, 85, 90, 70, 50, 30],
                'historic' => [12, 40, 80, 85, 65, 45, 25],
                'capacity' => [100, 100, 100, 100, 100, 100, 100]
            ],
            'trend_data_mp' => ['labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'], 'data' => [65, 70, 75, 80, 85, 90, 85]],
            'trend_data_vc' => ['labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'], 'data' => [45, 50, 55, 60, 65, 70, 65]],
            'trend_data_com' => ['labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'], 'data' => [20, 25, 30, 35, 40, 45, 40]],
        ];

        $this->view('admin/dashboard_predicciones', $data);
    }
}


