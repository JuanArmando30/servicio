<div class="container mt-4">
  <h3 class="fw-semibold my-2">Generación de Códigos QR</h3>
  <p class="text-muted small">Administra y genera códigos para alumnos</p>

  <div class="row mt-4">

    <!-- Generar individual -->
    <div class="col-md-6 mb-3">
      <div class="card shadow-sm text-center p-4">
        <h5>Generar QR Individual</h5>
        <p class="text-muted">Registrar un nuevo alumno manualmente</p>
        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalIndividual">
          Generar
        </button>
      </div>
    </div>

    <!-- Generar masivo -->
    <div class="col-md-6 mb-3">
      <div class="card shadow-sm text-center p-4">
        <h5>Generar QR Masivo</h5>
        <p class="text-muted">Subir archivo Excel con alumnos</p>
        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalExcel">
          Subir Excel
        </button>
      </div>
    </div>

  </div>

  <!-- Zona de seguimiento -->
  <div class="row mt-4">
    <div class="col-md-4 mb-2 m-lg-0">
      <div class="card p-3 shadow-sm">
        <h6>Total de QR generados</h6>
        <h4 id="statTotal">
          <span class="spinner-border spinner-border-sm text-warning"></span>
        </h4>
      </div>
    </div>
    <div class="col-md-4 my-2 m-lg-0">
      <div class="card p-3 shadow-sm">
        <h6>Generados hoy</h6>
        <h4 id="statHoy">
          <span class="spinner-border spinner-border-sm text-warning"></span>
        </h4>
      </div>
    </div>
    <div class="col-md-4 my-2 m-lg-0">
      <div class="card p-3 shadow-sm">
        <h6>Última generación</h6>
        <h4 id="statUltimo" style="font-size: 1.3rem;">
          <span class="spinner-border spinner-border-sm text-warning"></span>
        </h4>
      </div>
    </div>
  </div>

  <!-- MODAL — QR Individual -->
  <div class="modal fade" id="modalIndividual">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Generar QR Individual</h5>
        </div>
        <div class="modal-body">
          <form id="formAlumno">
            <div class="mb-2">
              <label>Nombre</label>
              <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-2">
              <label>Grado</label>
              <input type="text" name="grado" class="form-control">
            </div>
            <div class="mb-2">
              <label>Grupo</label>
              <input type="text" name="grupo" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-warning" id="btnGenerar">Generar QR</button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL — QR Masivo (Excel) -->
  <div class="modal fade" id="modalExcel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Subir archivo Excel</h5>
        </div>
        <div class="modal-body">

          <!-- Indicaciones del formato esperado -->
          <div class="alert alert-info py-2 mb-3">
            <i class="bi bi-info-circle me-1"></i>
            El archivo debe tener columnas en este orden:
            <strong>Nombre | Grado | Grupo</strong>
            <br><small class="text-muted">La primera fila puede ser encabezado o datos directamente.</small>
          </div>

          <form id="formExcel">
            <div class="mb-2">
              <label class="form-label">Selecciona el archivo</label>
              <input type="file" id="archivoExcel" class="form-control" accept=".xlsx,.xls" required>
            </div>

            <!-- Barra de progreso (oculta al inicio) -->
            <div id="progresoExcel" class="mt-3" style="display:none;">
              <label class="form-label text-muted">Procesando alumnos...</label>
              <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                  style="width: 100%"></div>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" data-bs-dismiss="modal" id="btnCancelarExcel">Cancelar</button>
          <button type="button" class="btn btn-warning" id="btnProcesarExcel">
            <i class="bi bi-upload me-1"></i> Procesar
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL — Éxito -->
  <div class="modal fade" id="modalExito" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg text-center p-4">
        <div class="mb-3">
          <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
        </div>
        <h4 class="fw-bold" id="exitoTitulo">¡QR Generado!</h4>
        <p class="text-muted" id="exitoMensaje">El código QR fue creado correctamente.</p>
        <button type="button" class="btn btn-warning px-5 mt-2" id="btnCerrarExito">Aceptar</button>
      </div>
    </div>
  </div>