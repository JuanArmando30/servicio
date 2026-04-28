<div class="alumnos-page p-4">

  <!-- ENCABEZADO -->
  <div class="mb-4 d-flex justify-content-between align-items-start flex-wrap gap-2">
    <div>
      <h3 class="fw-semibold mb-0">Alumnos</h3>
      <p class="text-muted small mb-0">Consulta y filtra los alumnos registrados</p>
    </div>
    <span class="badge-contador">
      <span id="totalAlumnos">–</span> alumno(s) encontrado(s)
    </span>
  </div>

  <!-- FILTROS -->
  <div class="card clean-card mb-4">
    <div class="card-body">
      <div class="row g-3 align-items-end">

        <!-- Nombre -->
        <div class="col-12 col-md-4">
          <label class="form-label filter-label">
            <i class="bi bi-search me-1"></i> Nombre
          </label>
          <input type="text" id="filtroNombre" class="form-control filter-input"
                 placeholder="Buscar por nombre...">
        </div>

        <!-- Grado -->
        <div class="col-6 col-md-3">
          <label class="form-label filter-label">
            <i class="bi bi-mortarboard me-1"></i> Grado
          </label>
          <select id="filtroGrado" class="form-select filter-input">
            <option value="">Todos</option>
          </select>
        </div>

        <!-- Grupo -->
        <div class="col-6 col-md-3">
          <label class="form-label filter-label">
            <i class="bi bi-diagram-3 me-1"></i> Grupo
          </label>
          <select id="filtroGrupo" class="form-select filter-input">
            <option value="">Todos</option>
          </select>
        </div>

        <!-- Botón limpiar -->
        <div class="col-12 col-md-2">
          <button class="btn btn-outline-secondary w-100" id="btnLimpiarFiltros">
            <i class="bi bi-x-circle me-1"></i> Limpiar
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- TABLA -->
  <div class="card clean-card">
    <div class="card-body p-0">

      <!-- Estado de carga -->
      <div id="estadoCarga" class="text-center py-5">
        <div class="spinner-border text-warning" role="status"></div>
        <p class="text-muted mt-2 mb-0">Cargando alumnos...</p>
      </div>

      <!-- Estado vacío -->
      <div id="estadoVacio" class="text-center py-5" style="display:none;">
        <i class="bi bi-person-x fs-1 text-muted"></i>
        <p class="text-muted mt-2 mb-0">No se encontraron alumnos con esos filtros.</p>
      </div>

      <!-- Tabla de resultados -->
      <div id="contenedorTabla" style="display:none;">
        <div class="table-responsive">
          <table class="tabla-alumnos w-100">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Grado</th>
                <th>Grupo</th>
                <th>Código QR</th>
                <th>Fecha de registro</th>
              </tr>
            </thead>
            <tbody id="tablaBody">
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

</div>