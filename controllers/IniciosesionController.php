<?php

class IniciosesionController extends Controller {

    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new User($this->db);
    }

    public function index() {
        if ($this->isLoggedIn()) {
            header('Location: /mi%20proyecto/');
        }

        $data = [
            'title' => 'Iniciar Sesión - InkaTours',
            'active_page' => 'iniciosesion'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['register'])) {
                $this->register();
            } elseif (isset($_POST['login'])) {
                $this->login();
            }
        } else {
            $this->view('iniciosesion', $data);
        }
    }

    public function register() {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'nombre' => trim($_POST['nombre']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'nombre_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        // Validate data
        if (empty($data['nombre'])) {
            $data['nombre_err'] = 'Por favor, ingrese su nombre';
        }
        if (empty($data['email'])) {
            $data['email_err'] = 'Por favor, ingrese su email';
        } else {
            if ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'El email ya está registrado';
            }
        }
        if (empty($data['password'])) {
            $data['password_err'] = 'Por favor, ingrese su contraseña';
        } elseif (strlen($data['password']) < 6) {
            $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres';
        }
        if (empty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Por favor, confirme su contraseña';
        } else {
            if ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Las contraseñas no coinciden';
            }
        }

        // Make sure errors are empty
        if (empty($data['nombre_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
            
            $this->userModel->nombre = $data['nombre'];
            $this->userModel->email = $data['email'];
            $this->userModel->password = $data['password'];
            $this->userModel->rol = 'usuario'; // Default role
            $this->userModel->avatar = 'default.jpg';
            $this->userModel->telefono = '';
            $this->userModel->pais = '';
            $this->userModel->fecha_nacimiento = null;
            $this->userModel->idioma_preferido = 'es';
            $this->userModel->notificaciones = true;
            $this->userModel->verificado = false;
            $this->userModel->token_verificacion = bin2hex(random_bytes(50));


            if ($this->userModel->register()) {
                // Redirect to login
                header('Location: /mi%20proyecto/iniciosesion?registro=exitoso');
            } else {
                die('Algo salió mal.');
            }
        } else {
            // Load view with errors
            $this->view('iniciosesion', $data);
        }
    }

    public function login() {
        // DO NOT Sanitize password, it needs to be raw for password_verify
        $data = [
            'email' => trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)),
            'password' => trim($_POST['password']),
            'email_err' => '',
            'password_err' => '',
        ];

        // Validate data
        if (empty($data['email'])) {
            $data['email_err'] = 'Por favor, ingrese su email';
        }
        if (empty($data['password'])) {
            $data['password_err'] = 'Por favor, ingrese su contraseña';
        }

        // Check for user/email
        if(empty($data['email_err']) && empty($data['password_err'])){
            $this->userModel->email = $data['email'];
            $this->userModel->password = $data['password'];

            if ($this->userModel->login()) {
                // Create session
                $this->createUserSession($this->userModel);

                // Redirect based on user role
                if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'admin') {
                    header('Location: /mi%20proyecto/admin/dashboard');
                    exit();
                }

                // Check for redirect_to parameter
                if (isset($_GET['redirect_to']) && !empty($_GET['redirect_to'])) {
                    $redirectTo = filter_var($_GET['redirect_to'], FILTER_SANITIZE_URL);
                    // Basic validation to prevent open redirection
                    if (strpos($redirectTo, '/mi%20proyecto/') === 0) {
                        header('Location: ' . $redirectTo);
                        exit();
                    }
                }
                header('Location: /mi%20proyecto/');
            } else {
                $data['password_err'] = 'Contraseña incorrecta';
                $this->view('iniciosesion', $data);
            }
        } else {
            // Load view with errors
            $this->view('iniciosesion', $data);
        }
    }

    public function createUserSession($user) {
        session_start();
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->nombre;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_rol'] = $user->rol;
    }

    public function logout() {
        session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_rol']);
        session_destroy();
        header('Location: /mi%20proyecto/');
    }

    public function isLoggedIn() {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}