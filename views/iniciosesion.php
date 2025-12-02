<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - InkaTours</title>
    
    <!-- Fuentes y Estilos Esenciales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2A9D8F;
            --secondary: #264653;
            --accent: #E9C46A;
            --accent-alt: #F4A261;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/mi%20proyecto/static/img/destinos/cusco.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 40px;
            color: white;
        }

        .login-tabs {
            display: flex;
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .tab-link {
            flex: 1;
            background: none;
            border: none;
            color: white;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .tab-link.active, .tab-link:hover {
            color: white;
            border-bottom-color: var(--accent);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
        
        .tab-content h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 2rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-group input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(233, 196, 106, 0.4);
            border-color: var(--accent);
            background: rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            background: linear-gradient(45deg, var(--accent-alt), var(--accent));
            color: var(--secondary);
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(244, 162, 97, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(244, 162, 97, 0.5);
        }

        .form-options {
            text-align: right;
            margin-bottom: 1.5rem;
        }

        .forgot-password {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: white;
            text-decoration: underline;
        }

        .btn-back-to-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 10px 20px;
            border: 1px solid white;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }

        .btn-back-to-home:hover {
            color: white;
            border-color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-back-to-home:visited {
            color: white;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <div class="login-tabs">
                <button class="tab-link active" onclick="openTab(event, 'login')">Iniciar Sesión</button>
                <button class="tab-link" onclick="openTab(event, 'register')">Registrarse</button>
            </div>

            <div id="login" class="tab-content active">
                <h2>Bienvenido de Vuelta</h2>
                <form action="/mi%20proyecto/iniciosesion" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" required>
                    </div>
                    
                    <div class="form-options">
                        <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <input type="submit" name="login" value="Ingresar" class="btn-primary">
                    </div>
                </form>
            </div>

            <div id="register" class="tab-content">
                <h2>Crear Cuenta</h2>
                <form action="/mi%20proyecto/iniciosesion" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña:</label>
                        <input type="password" name="confirm_password" required>
                    </div>
                    <div class="form-group" style="margin-top: 2rem;">
                        <input type="submit" name="register" value="Registrarse" class="btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <a href="/mi%20proyecto/" class="btn-back-to-home">
        <i class="fas fa-chevron-left"></i> Regresar al Inicio
    </a>

    <script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    // Set the first tab as active on page load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.tab-link.active').click();
    });
    </script>

</body>
</html>