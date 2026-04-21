<?php
$pagina = isset($_GET['op']) ? strtolower($_GET['op']) : 'dashboard';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Comedor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/SERVICIO/assets/css/menu.css">
    <link rel="stylesheet" href="/SERVICIO/assets/css/dashboard.css">
</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar (se posiciona solo en desktop, overlay en móvil) -->
        <?php include('menu.php'); ?>

        <!-- Contenido principal -->
        <div id="page-content-wrapper" class="flex-grow-1 d-flex flex-column">

            <!-- Topbar móvil: contiene el botón toggle -->
            <nav class="navbar bg-dark d-md-none px-3">
                <button class="btn btn-outline-light" 
                        data-bs-toggle="offcanvas" 
                        data-bs-target="#sidebarMenu">
                    <i class="bi bi-list fs-4"></i>
                </button>
            </nav>

            <!-- Página actual -->
            <div class="p-3 flex-grow-1">
                <?php require_once $pagina . '.php'; ?>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../assets/js/graficaDashboard.js"></script>

</body>
</html>