<?php

class ReservasController extends Controller {
    private $reservaModel;
    private $destinoModel;
    private $actividadModel;
    private $reservaDestinoModel;
    private $reservaActividadModel;
    private $participanteReservaModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->reservaModel = new Reserva($db);
        $this->destinoModel = new Destino($db);
        $this->actividadModel = new Actividad($db);
        $this->reservaDestinoModel = new ReservaDestino($db);
        $this->reservaActividadModel = new ReservaActividad($db);
        $this->participanteReservaModel = new ParticipanteReserva($db);
    }

    public function index() {
        $this->view('reservas');
    }

    public function crear($tipo, $id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /mi%20proyecto/');
            exit();
        }

        $item = null;
        if ($tipo == 'destino') {
            $this->destinoModel->id = $id;
            $this->destinoModel->read_single();
            $item = $this->destinoModel;
        } elseif ($tipo == 'actividad') {
            $this->actividadModel->id = $id;
            $this->actividadModel->read_single();
            $item = $this->actividadModel;
        }

        $data = [
            'title' => 'Confirmar Reserva - InkaTours',
            'active_page' => 'reservas',
            'tipo' => $tipo,
            'item' => $item
        ];

        $this->view('reservas', $data);
    }

    public function guardar() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /mi%20proyecto/');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'usuario_id' => $_SESSION['user_id'],
                'tipo' => trim($_POST['tipo']),
                'elemento_id' => trim($_POST['elemento_id']),
                'fecha_experiencia' => trim($_POST['fecha_experiencia']),
                'participantes' => trim($_POST['participantes']),
                'precio_unitario' => trim($_POST['precio_unitario']),
                'notas' => trim($_POST['notas']),
                'nombre_completo' => trim($_POST['nombre_completo']),
                'email' => trim($_POST['email']),
                'telefono' => trim($_POST['telefono']),
                'fecha_err' => '',
                'participantes_err' => '',
                'nombre_err' => '',
                'email_err' => ''
            ];

            // Validate data
            if (empty($data['fecha_experiencia'])) {
                $data['fecha_err'] = 'Por favor, seleccione una fecha.';
            }
            if (empty($data['participantes']) || $data['participantes'] < 1) {
                $data['participantes_err'] = 'Por favor, ingrese un número válido de participantes.';
            }
            if (empty($data['nombre_completo'])) {
                $data['nombre_err'] = 'Por favor, ingrese su nombre completo.';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor, ingrese su email.';
            }

            if (empty($data['fecha_err']) && empty($data['participantes_err']) && empty($data['nombre_err']) && empty($data['email_err'])) {
                // All data is valid, proceed to create reservation
                $this->reservaModel->usuario_id = $data['usuario_id'];
                $this->reservaModel->tipo = $data['tipo'];
                $this->reservaModel->fecha_experiencia = $data['fecha_experiencia'];
                $this->reservaModel->participantes = $data['participantes'];
                $this->reservaModel->precio_unitario = $data['precio_unitario'];
                $this->reservaModel->subtotal = $data['precio_unitario'] * $data['participantes'];
                // Cobrar el 50% al momento de la reserva inicial
                $this->reservaModel->total = $this->reservaModel->subtotal / 2;
                $this->reservaModel->notas = $data['notas'];
                $this->reservaModel->numero_reserva = 'INKA-' . time();
                $this->reservaModel->estado = 'pendiente';
                $this->reservaModel->fecha_reserva = date('Y-m-d H:i:s');
                $this->reservaModel->moneda = 'USD';
                $this->reservaModel->metodo_pago = 'tarjeta';

                if ($this->reservaModel->create()) {
                    $reserva_id = $this->reservaModel->getLastInsertId();

                    // Save main participant info
                    $this->participanteReservaModel->reserva_id = $reserva_id;
                    $this->participanteReservaModel->nombre = $data['nombre_completo'];
                    $this->participanteReservaModel->email = $data['email'];
                    $this->participanteReservaModel->telefono = $data['telefono'];
                    $this->participanteReservaModel->create();

                    // Save reservation-destination link
                    if ($data['tipo'] == 'destino') {
                        $this->reservaDestinoModel->reserva_id = $reserva_id;
                        $this->reservaDestinoModel->destino_id = $data['elemento_id'];
                        $this->reservaDestinoModel->precio = $data['precio_unitario'];
                        $this->reservaDestinoModel->create();
                    } elseif ($data['tipo'] == 'actividad') {
                        $this->reservaActividadModel->reserva_id = $reserva_id;
                        $this->reservaActividadModel->actividad_id = $data['elemento_id'];
                        $this->reservaActividadModel->precio = $data['precio_unitario'];
                        $this->reservaActividadModel->create();
                    }
                    
                    // Redirect to success page with reservation number
                    header('Location: /mi%20proyecto/reservas/exito/' . $this->reservaModel->numero_reserva);
                } else {
                    die('Algo salió mal al crear la reserva.');
                }
            } else {
                // Reload form with errors
                // We need to fetch the item data again to render the view
                $item = null;
                if ($data['tipo'] == 'destino') {
                    $this->destinoModel->id = $data['elemento_id'];
                    $this->destinoModel->read_single();
                    $item = $this->destinoModel;
                } // Add logic for 'actividad' if needed
                
                $data['item'] = $item;
                $data['title'] = 'Confirmar Reserva - InkaTours';
                $data['active_page'] = 'reservas';

                $this->view('reservas', $data);
            }
        }
    }

    public function exito($numero_reserva = '') {
        $reserva = $this->reservaModel->getReservaByNumero($numero_reserva);

        $data = [
            'title' => 'Reserva Exitosa - InkaTours',
            'active_page' => 'reservas',
            'reserva' => $reserva
        ];
        $this->view('reserva_exitosa', $data);
    }

    public function comprobante($numero_reserva = '') {
        // Fetch reservation data
        $reserva = $this->reservaModel->getReservaByNumero($numero_reserva);

        if (!$reserva) {
            die('Comprobante no encontrado.');
        }

        // Require FPDF library
        require($_SERVER['DOCUMENT_ROOT'] . '/mi proyecto/core/lib/fpdf/fpdf.php');

        // Create PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Header
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 10, 'InkaTours - Comprobante de Reserva', 0, 1, 'C');
        $pdf->Ln(10);

        // Reservation Details
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Resumen de la Reserva', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, 'Numero de Reserva: ' . $reserva['numero_reserva'], 0, 1);
        $pdf->Cell(0, 8, 'Actividad/Destino: ' . $reserva['item_nombre'], 0, 1);
        $pdf->Cell(0, 8, 'Fecha de Experiencia: ' . date('d/m/Y', strtotime($reserva['fecha_experiencia'])), 0, 1);
        $pdf->Cell(0, 8, 'Participantes: ' . $reserva['participantes'], 0, 1);
        $pdf->Ln(10);

        // User Details
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Datos del Cliente', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, 'Nombre: ' . $reserva['usuario_nombre'], 0, 1);
        $pdf->Cell(0, 8, 'Email: ' . $reserva['usuario_email'], 0, 1);
        $pdf->Ln(10);

        // Total
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Total Pagado (50%): $' . number_format($reserva['total'], 2) . ' ' . $reserva['moneda'], 0, 1, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Monto total de la reserva: $' . number_format($reserva['subtotal'], 2) . ' ' . $reserva['moneda'], 0, 1, 'R');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, 'El 50% restante se pagara al confirmar la reserva.', 0, 1, 'R');


        // Output PDF
        $pdf->Output('D', 'comprobante_' . $reserva['numero_reserva'] . '.pdf');
    }

    public function confirmar($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit();
        }

        $reserva = $this->reservaModel->getById($id);

        // Security check and ensure status is 'pendiente'
        if (!$reserva || $reserva['usuario_id'] != $_SESSION['user_id'] || $reserva['estado'] != 'pendiente') {
            header('Location: /mi%20proyecto/perfil/reservas');
            exit();
        }

        // Pass reservation data to the new confirmation view
        $data = [
            'title' => 'Confirmar Pago Final',
            'active_page' => 'reservas',
            'reserva' => $reserva
        ];
        
        $this->view('reserva_confirmar', $data);
    }

    public function procesar_confirmacion() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            die('Acceso no autorizado.');
        }

        $reserva_id = $_POST['reserva_id'];
        $reserva = $this->reservaModel->getById($reserva_id);

        // Security check
        if (!$reserva || $reserva['usuario_id'] != $_SESSION['user_id'] || $reserva['estado'] != 'pendiente') {
            die('Operación no válida o no autorizada.');
        }

        // ** SIMULACIÓN DE PAGO FINAL **
        $pago_final_exitoso = true; // Simulación

        if ($pago_final_exitoso) {
            // El subtotal contiene el 100% del precio
            if ($this->reservaModel->confirmarPagoCompleto($reserva_id, $reserva['subtotal'])) {
                // Redirigir al perfil de reservas con un mensaje de éxito.
                $_SESSION['reserva_confirmada'] = '¡Tu reserva ha sido confirmada y pagada con éxito!';
                header('Location: /mi%20proyecto/perfil/reservas');
                exit();
            } else {
                die('Error al actualizar la base de datos de la reserva.');
            }
        } else {
            die('Error al procesar el pago final. Por favor, intente de nuevo.');
        }
    }

    public function comprobante_final($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit();
        }
        
        $reserva = $this->reservaModel->getById($id);

        if (!$reserva || $reserva['usuario_id'] != $_SESSION['user_id']) {
            die('Comprobante no encontrado o no autorizado.');
        }

        // Para obtener el nombre del destino, necesitamos una consulta más compleja
        // o añadir el dato al resultado de getById. Por simplicidad, re-usamos getReservaByNumero
        $reserva_completa = $this->reservaModel->getReservaByNumero($reserva['numero_reserva']);

        require($_SERVER['DOCUMENT_ROOT'] . '/mi proyecto/core/lib/fpdf/fpdf.php');

        $pdf = new FPDF();
        $pdf->AddPage();
        
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 10, 'InkaTours - Comprobante de Confirmacion', 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reserva Confirmada y Pagada', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, 'Numero de Reserva: ' . $reserva_completa['numero_reserva'], 0, 1);
        $pdf->Cell(0, 8, 'Actividad/Destino: ' . $reserva_completa['item_nombre'], 0, 1);
        $pdf->Cell(0, 8, 'Fecha de Experiencia: ' . date('d/m/Y', strtotime($reserva_completa['fecha_experiencia'])), 0, 1);
        $pdf->Cell(0, 8, 'Participantes: ' . $reserva_completa['participantes'], 0, 1);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Datos del Cliente', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, 'Nombre: ' . $reserva_completa['usuario_nombre'], 0, 1);
        $pdf->Cell(0, 8, 'Email: ' . $reserva_completa['usuario_email'], 0, 1);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Total Pagado: $' . number_format($reserva_completa['total'], 2) . ' ' . $reserva_completa['moneda'], 0, 1, 'R');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Gracias por su preferencia!', 0, 1, 'C');

        $pdf->Output('D', 'comprobante_final_' . $reserva_completa['numero_reserva'] . '.pdf');
    }
    
    public function cancelar($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /mi%20proyecto/iniciosesion');
            exit();
        }

        $reserva = $this->reservaModel->getById($id);

        // Security check: ensure the reservation belongs to the logged-in user
        if (!$reserva || $reserva['usuario_id'] != $_SESSION['user_id']) {
            die('Acceso no autorizado.');
        }

        // Only allow cancellation if the status is pending
        if ($reserva['estado'] == 'pendiente') {
            if ($this->reservaModel->updateEstado($id, 'cancelada')) {
                // Opcional: Crear una notificación o un mensaje flash.
            } else {
                // Opcional: Manejar el error.
            }
        }

        // Redirigir de vuelta a la página de mis reservas
        header('Location: /mi%20proyecto/perfil/reservas');
        exit();
    }
}