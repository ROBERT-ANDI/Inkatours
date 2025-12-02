<?php

class PrediccionesController extends Controller {
    private $prediccionModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->prediccionModel = new Prediccion($db);
    }

    public function index() {
        // Data for Alerts for the new view
        $alertas_tiempo_real = [
            ['nivel' => 'critical', 'titulo' => 'Alerta de Capacidad: Camino Inca', 'mensaje' => 'Permisos para el Camino Inca están al 100% de su capacidad para los próximos 15 días.', 'tiempo' => 'Hace 15 minutos'],
            ['nivel' => 'warning', 'titulo' => 'Afluencia Alta en Machu Picchu', 'mensaje' => 'Se espera que la afluencia supere el 90% entre las 10:00 y las 14:00.', 'tiempo' => 'Hace 1 hora'],
            ['nivel' => 'info', 'titulo' => 'Evento Cultural en Cusco', 'mensaje' => 'Festival Inti Raymi incrementará afluencia en zonas céntricas.', 'tiempo' => 'Hace 3 horas'],
        ];

        // Dummy data for map points (destinos_mapa) - based on previous heatmap data
        $destinos_mapa = [
            ['nombre' => 'Machu Picchu', 'congestion' => 92, 'recomendacion' => 'Visitar en horarios de baja afluencia.', 'nivel' => 'crowded', 'pos_x' => 20, 'pos_y' => 30, 'mejor_hora' => '6:00 - 8:00 AM'],
            ['nombre' => 'Montaña 7 Colores', 'congestion' => 75, 'recomendacion' => 'Se recomienda buena aclimatación.', 'nivel' => 'busy', 'pos_x' => 45, 'pos_y' => 60, 'mejor_hora' => '9:00 - 11:00 AM'],
            ['nombre' => 'Valle Sagrado', 'congestion' => 55, 'recomendacion' => 'Ideal para visitas de día completo.', 'nivel' => 'moderate', 'pos_x' => 35, 'pos_y' => 45, 'mejor_hora' => 'Tarde'],
            ['nombre' => 'Camino Inca', 'congestion' => 100, 'recomendacion' => 'Permisos agotados.', 'nivel' => 'crowded', 'pos_x' => 25, 'pos_y' => 40, 'mejor_hora' => 'N/A'],
            ['nombre' => 'Laguna Humantay', 'congestion' => 65, 'recomendacion' => 'Llevar ropa abrigadora.', 'nivel' => 'busy', 'pos_x' => 50, 'pos_y' => 70, 'mejor_hora' => 'Temprano'],
            ['nombre' => 'Salineras de Maras', 'congestion' => 40, 'recomendacion' => 'Excelente para fotografía.', 'nivel' => 'moderate', 'pos_x' => 30, 'pos_y' => 55, 'mejor_hora' => 'Cualquier hora'],
            ['nombre' => 'Moray', 'congestion' => 25, 'recomendacion' => 'Ingeniería agrícola inca impresionante.', 'nivel' => 'free', 'pos_x' => 28, 'pos_y' => 50, 'mejor_hora' => 'Mañana'],
            ['nombre' => 'Ollantaytambo', 'congestion' => 60, 'recomendacion' => 'Pueblo inca viviente.', 'nivel' => 'moderate', 'pos_x' => 30, 'pos_y' => 35, 'mejor_hora' => 'Tarde'],
            ['nombre' => 'Pisac', 'congestion' => 50, 'recomendacion' => 'Mercado artesanal y ruinas incas.', 'nivel' => 'moderate', 'pos_x' => 40, 'pos_y' => 30, 'mejor_hora' => 'Mañana'],
            ['nombre' => 'Sacsayhuaman', 'congestion' => 80, 'recomendacion' => 'Gran fortaleza inca.', 'nivel' => 'busy', 'pos_x' => 20, 'pos_y' => 20, 'mejor_hora' => 'Temprano'],
            ['nombre' => 'Qorikancha', 'congestion' => 70, 'recomendacion' => 'Templo de Oro inca.', 'nivel' => 'busy', 'pos_x' => 22, 'pos_y' => 25, 'mejor_hora' => 'Tarde'],
            ['nombre' => 'Piquillacta', 'congestion' => 20, 'recomendacion' => 'Ciudad pre-inca Wari.', 'nivel' => 'free', 'pos_x' => 60, 'pos_y' => 40, 'mejor_hora' => 'Cualquier hora'],
            ['nombre' => 'Tipon', 'congestion' => 15, 'recomendacion' => 'Complejo agrícola inca.', 'nivel' => 'free', 'pos_x' => 55, 'pos_y' => 45, 'mejor_hora' => 'Cualquier hora'],
        ];

        // Calculate estadisticas based on destinos_mapa (dummy)
        $estadisticas = [
            'libre' => 0,
            'moderado' => 0,
            'ocupado' => 0,
            'congestionado' => 0,
        ];

        foreach ($destinos_mapa as $destino) {
            if ($destino['congestion'] <= 30) {
                $estadisticas['libre']++;
            } elseif ($destino['congestion'] <= 60) {
                $estadisticas['moderado']++;
            } elseif ($destino['congestion'] <= 80) {
                $estadisticas['ocupado']++;
            } else {
                $estadisticas['congestionado']++;
            }
        }

        // Dummy data for weekly predictions
        $predicciones_semana = [];
        for ($i = 0; $i < 7; $i++) {
            $predicciones_semana[] = rand(40, 95); // Random prediction between 40% and 95%
        }

        $data = [
            'title' => 'InkaTours - Predicciones Inteligentes',
            'active_page' => 'predicciones', // Ensure this matches the menu
            'alertas_tiempo_real' => $alertas_tiempo_real,
            'estadisticas' => $estadisticas,
            'destinos_mapa' => $destinos_mapa,
            'predicciones_semana' => $predicciones_semana,
        ];
        
        $this->view('predicciones', $data);
    }
}