<div class="dashboard p-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-semibold">Dashboard</h3>
        <p class="text-muted small mb-0">Resumen general del sistema</p>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <span class="stat-title">Alumnos</span>
                <h4>120</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <span class="stat-title">Pagos hoy</span>
                <h4>35</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <span class="stat-title">Recaudado</span>
                <h4>$2,150</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="stat-card">
                <span class="stat-title">Adeudos</span>
                <h4>18</h4>
            </div>
        </div>

    </div>

    <!-- CONTENIDO -->
    <div class="row g-4">

        <!-- GRAFICA -->
        <div class="col-12">
            <div class="card clean-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="fw-semibold mb-0">Pagos de la semana</h6>
                    </div>
                    <canvas id="graficaPagos"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>