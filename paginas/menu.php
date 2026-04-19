<?php
$currentPage = isset($_GET['op']) ? strtolower($_GET['op']) : 'bienvenida';
?>

<!-- BOTÓN PARA ABRIR SIDEBAR (solo en móvil) -->
<button class="btn btn-dark d-md-none m-3" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
    ☰ Menú
</button>

<!-- SIDEBAR -->
<div class="offcanvas-md offcanvas-start bg-dark text-white px-1" tabindex="-1" id="sidebarMenu">

    <div class="offcanvas-header d-md-none">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="d-flex flex-column p-3 vh-100">

        <!-- PERFIL DE USUARIO -->
        <div class="text-center my-5">
            <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="usuario">
            <h6 class="fw-bold mb-0">Juan Armando</h6>
            <small class="text-secondary">Administrador</small>
        </div>

        <!-- MENÚ -->
        <ul class="nav nav-pills flex-column mb-auto mt-1">

            <li class="nav-item">
                <a href="?op=dashboard" class="nav-link text-white <?php echo ($pagina == 'dashboard') ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="?op=alumnos" class="nav-link text-white <?php echo ($pagina == 'alumnos') ? 'active' : ''; ?>">
                    <i class="bi bi-people me-2"></i> Alumnos
                </a>
            </li>

            <li>
                <a href="?op=pagos" class="nav-link text-white <?php echo ($pagina == 'pagos') ? 'active' : ''; ?>">
                    <i class="bi bi-cash-coin me-2"></i> Pagos
                </a>
            </li>

            <li>
                <a href="?op=qr" class="nav-link text-white <?php echo ($pagina == 'qr') ? 'active' : ''; ?>">
                    <i class="bi bi-qr-code-scan me-2"></i> Escanear QR
                </a>
            </li>

            <li>
                <a href="?op=reportes" class="nav-link text-white <?php echo ($pagina == 'reportes') ? 'active' : ''; ?>">
                    <i class="bi bi-bar-chart me-2"></i> Reportes
                </a>
            </li>

        </ul>

        <hr class="text-secondary">

        <!-- CERRAR SESIÓN -->
        <div>
            <a href="#" class="nav-link logout-btn text-center my-2 p-1">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
            </a>
        </div>

    </div>
</div>