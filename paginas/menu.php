<?php
$currentPage = isset($_GET['op']) ? strtolower($_GET['op']) : 'bienvenida';
?>

<!-- SIDEBAR -->
<div class="offcanvas-md offcanvas-start bg-dark text-white" 
     tabindex="-1" 
     id="sidebarMenu" 
     aria-labelledby="sidebarMenuLabel">

    <!-- Header solo en móvil -->
    <div class="offcanvas-header d-md-none border-bottom border-secondary">
        <h6 class="offcanvas-title text-white" id="sidebarMenuLabel">Sistema Integral VG</h6>
        <button type="button" class="btn-close btn-close-white" 
                data-bs-dismiss="offcanvas" 
                data-bs-target="#sidebarMenu"></button>
    </div>

    <!-- Contenido del sidebar -->
    <div class="offcanvas-body d-flex flex-column p-3">

        <!-- PERFIL -->
        <div class="text-center my-5">
            <img src="../assets/img/logo.png" 
                 class="mb-2 w-25" 
                 alt="usuario">
            <h6 class="fw-bold mb-0 text-white">Juan Armando</h6>
            <small class="text-secondary">Administrador</small>
        </div>

        <!-- NAVEGACIÓN -->
        <ul class="nav nav-pills flex-column mb-auto">

            <li class="nav-item">
                <a href="?op=dashboard" 
                   class="nav-link text-white <?php echo ($currentPage == 'dashboard') ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="?op=alumnos" 
                   class="nav-link text-white <?php echo ($currentPage == 'alumnos') ? 'active' : ''; ?>">
                    <i class="bi bi-people me-2"></i> Alumnos
                </a>
            </li>

            <li class="nav-item">
                <a href="?op=pagos" 
                   class="nav-link text-white <?php echo ($currentPage == 'pagos') ? 'active' : ''; ?>">
                    <i class="bi bi-cash-coin me-2"></i> Pagos
                </a>
            </li>

            <li class="nav-item">
                <a href="?op=qr" 
                   class="nav-link text-white <?php echo ($currentPage == 'qr') ? 'active' : ''; ?>">
                    <i class="bi bi-qr-code-scan me-2"></i> Generar QR
                </a>
            </li>

            <li class="nav-item">
                <a href="?op=reportes" 
                   class="nav-link text-white <?php echo ($currentPage == 'reportes') ? 'active' : ''; ?>">
                    <i class="bi bi-bar-chart me-2"></i> Reportes
                </a>
            </li>

        </ul>

        <hr class="text-secondary">

        <!-- CERRAR SESIÓN -->
        <a href="#" class="nav-link logout-btn text-center p-2">
            <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
        </a>

    </div>
</div>