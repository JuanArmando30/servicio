<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Escolar</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    <link rel="stylesheet" href="assets/css/login.css">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fuente -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>

    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center login-container">
        <div class="row w-100 h-100">

            <!-- LADO IZQUIERDO -->
            <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center text-white left-section">
                <div class="content px-5 content_information">
                    <h1 class="fw-bold display-4 d-flex align-items-center gap-3">
                        <img src="assets/img/logo.png" alt="Logo" width="105" class="me-2">
                        <span> Esc. Prim. Vicente Guerrero </span>
                    </h1>

                    <p class="mt-4 phrase">
                        <span> El educador es el hombre que hace que las cosas difíciles parezcan fáciles </span>
                        <span> - Ralph Waldo Emerson </span>
                    </p>
                </div>
            </div>

            <!-- LADO DERECHO -->
            <div class="col-lg-6 col-12 d-flex align-items-center justify-content-center">
                <div class="login-card p-5">

                    <h3 class="mb-4 fw-bold text-center">Iniciar sesión</h3>

                    <form>
                        <div class="mb-3">
                            <input type="text" placeholder="Ingresa tu usuario" name="user" value="">
                        </div>

                        <div class="mb-3">
                            <div class="password-container">
                                <input type="password" id="passwordInput" placeholder="Ingresa tu contraseña" name="password">
                                <span id="togglePassword" class="material-icons">visibility</span>
                            </div>
                        </div>

                        <label id= "remember_user">
                            <input type="checkbox" name="recordarUsuario">
                            <span>Recordar usuario</span>
                        </label>

                        <a href="paginas/main.php" class="btn btn-warning w-100 mb-3 mt-3">
                            Iniciar sesión
                        </a>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script src="assets/js/login.js"></script>

</body>

</html>