<div class="container mt-4">
    <h2 class="my-1">Generación de Códigos QR</h2>
    <p class="text-muted">Administra y genera códigos para alumnos</p>

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
                <h3>120</h3>
            </div>
        </div>

        <div class="col-md-4 my-2 m-lg-0">
            <div class="card p-3 shadow-sm">
                <h6>Generados hoy</h6>
                <h3>15</h3>
            </div>
        </div>

        <div class="col-md-4 my-2 m-lg-0">
            <div class="card p-3 shadow-sm">
                <h6>Última generación</h6>
                <h3>Hace 10 minutos</h3>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalIndividual">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5>Generar QR Individual</h5>
      </div>
      <div class="modal-body">

        <form id="formAlumno">
          <div class="mb-2">
            <label>Nombre</label>
            <input type="text" class="form-control" required>
          </div>

          <div class="mb-2">
            <label>Grado</label>
            <input type="text" class="form-control">
          </div>

          <div class="mb-2">
            <label>Grupo</label>
            <input type="text" class="form-control">
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-warning">Generar QR</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalExcel">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5>Subir archivo Excel</h5>
      </div>
      <div class="modal-body">

        <form>
          <div class="mb-3">
            <label>Seleccionar archivo</label>
            <input type="file" class="form-control" accept=".xlsx, .xls">
          </div>

          <small class="text-muted">
            El archivo debe contener: Nombre, Grado, Grupo
          </small>
        </form>

      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-warning">Procesar</button>
      </div>
    </div>
  </div>
</div>