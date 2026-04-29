<div class="pagos-page p-4">

  <!-- ENCABEZADO -->
  <div class="mb-4">
    <h3 class="fw-semibold mb-2">Registro de Pagos</h3>
    <p class="text-muted small">Escanea el QR del alumno para registrar asistencia a comedor y computación</p>
  </div>

  <div class="row g-4">

    <!-- ── COLUMNA IZQUIERDA: escáner + búsqueda manual ── -->
    <div class="col-12 col-lg-5">

      <div class="card clean-card h-100">
        <div class="card-body d-flex flex-column gap-4">

          <!-- Área de escaneo QR -->
          <div>
            <h6 class="fw-bold mb-3">
              <i class="bi bi-qr-code-scan me-2 text-warning"></i>Escanear QR
            </h6>

            <div id="areaScanner" class="scanner-box">
              <div id="scannerVideo"></div>
              <div id="scannerPlaceholder" class="scanner-placeholder">
                <i class="bi bi-camera fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-3 small">Activa la cámara para escanear</p>
                <button class="btn btn-warning btn-sm px-4" id="btnActivarCamara">
                  <i class="bi bi-camera me-1"></i> Activar cámara
                </button>
              </div>
              <div id="scannerActivo" style="display:none;">
                <video id="videoQR" autoplay playsinline class="w-100 rounded-3"></video>
                <div class="scanner-line"></div>
                <button class="btn btn-sm btn-outline-secondary mt-2 w-100" id="btnDetenerCamara">
                  <i class="bi bi-stop-circle me-1"></i> Detener cámara
                </button>
              </div>
            </div>
          </div>

          <!-- Separador -->
          <div class="d-flex align-items-center gap-2">
            <hr class="flex-grow-1 m-0">
            <span class="text-muted small">o ingresa el código manualmente</span>
            <hr class="flex-grow-1 m-0">
          </div>

          <!-- Búsqueda manual -->
          <div>
            <div class="input-group">
              <input type="text" id="inputCodigo" class="form-control"
                     placeholder="Pega o escribe el código QR...">
              <button class="btn btn-warning px-3" id="btnBuscar">
                <i class="bi bi-search"></i>
              </button>
            </div>
            <div id="errorBusqueda" class="text-danger small mt-1" style="display:none;"></div>
          </div>

        </div>
      </div>

    </div>

    <!-- ── COLUMNA DERECHA: formulario de pago ── -->
    <div class="col-12 col-lg-7">

      <!-- Estado inicial (sin alumno) -->
      <div id="panelVacio" class="card clean-card h-100">
        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center py-5">
          <i class="bi bi-person-bounding-box fs-1 text-muted mb-3"></i>
          <h6 class="text-muted fw-normal">Escanea o busca un alumno para comenzar</h6>
        </div>
      </div>

      <!-- Panel de pago (aparece al encontrar alumno) -->
      <div id="panelPago" class="flex-column gap-3" style="display:none !important;">

        <!-- Tarjeta del alumno -->
        <div class="card clean-card">
          <div class="card-body d-flex align-items-center gap-3">
            <div class="avatar-alumno">
              <i class="bi bi-person-fill"></i>
            </div>
            <div>
              <h5 class="mb-0 fw-bold" id="pagoNombre">–</h5>
              <span class="badge-grado me-1" id="pagoGrado">–</span>
              <span class="badge-grupo" id="pagoGrupo">–</span>
            </div>
            <div class="ms-auto text-end">
              <small class="text-muted d-block">Semana</small>
              <strong id="pagoSemana" class="text-warning">–</strong>
            </div>
          </div>
        </div>

        <!-- Días de asistencia -->
        <div class="card clean-card">
          <div class="card-body">
            <h6 class="fw-bold mb-3">
              <i class="bi bi-calendar-week me-2 text-warning"></i>
              Días de asistencia al comedor
            </h6>
            <div class="dias-grid">
              <label class="dia-toggle" id="toggle-lunes">
                <input type="checkbox" name="dia" value="lunes" id="chk-lunes">
                <span class="dia-label">
                  <span class="dia-letra">L</span>
                  <span class="dia-nombre">Lun</span>
                </span>
              </label>
              <label class="dia-toggle" id="toggle-martes">
                <input type="checkbox" name="dia" value="martes" id="chk-martes">
                <span class="dia-label">
                  <span class="dia-letra">M</span>
                  <span class="dia-nombre">Mar</span>
                </span>
              </label>
              <label class="dia-toggle" id="toggle-miercoles">
                <input type="checkbox" name="dia" value="miercoles" id="chk-miercoles">
                <span class="dia-label">
                  <span class="dia-letra">M</span>
                  <span class="dia-nombre">Mié</span>
                </span>
              </label>
              <label class="dia-toggle" id="toggle-jueves">
                <input type="checkbox" name="dia" value="jueves" id="chk-jueves">
                <span class="dia-label">
                  <span class="dia-letra">J</span>
                  <span class="dia-nombre">Jue</span>
                </span>
              </label>
              <label class="dia-toggle" id="toggle-viernes">
                <input type="checkbox" name="dia" value="viernes" id="chk-viernes">
                <span class="dia-label">
                  <span class="dia-letra">V</span>
                  <span class="dia-nombre">Vie</span>
                </span>
              </label>
            </div>
          </div>
        </div>

        <!-- Resumen de cobro -->
        <div class="card clean-card">
          <div class="card-body">
            <h6 class="fw-bold mb-3">
              <i class="bi bi-receipt me-2 text-warning"></i>
              Resumen de cobro
            </h6>

            <div class="resumen-fila">
              <span>Días de comedor</span>
              <span id="resDias">0 días</span>
            </div>
            <div class="resumen-fila">
              <span>Comedor (<span id="resDiasCobro">0</span> × $20)</span>
              <span id="resComedor">$0.00</span>
            </div>
            <div class="resumen-fila">
              <span>
                Computación
                <small class="text-muted" id="resDescuento"></small>
              </span>
              <span id="resComputo">$15.00</span>
            </div>
            <hr class="my-2">
            <div class="resumen-fila resumen-total">
              <span>Total a cobrar</span>
              <span id="resTotal">$15.00</span>
            </div>

            <!-- Barra visual de descuento computación -->
            <div class="mt-3">
              <div class="d-flex justify-content-between mb-1">
                <small class="text-muted">Descuento computación</small>
                <small class="text-success fw-bold" id="resDescuentoPct">0%</small>
              </div>
              <div class="progress" style="height:6px;">
                <div id="barraDescuento"
                     class="progress-bar bg-success"
                     style="width: 0%; transition: width 0.4s ease;"></div>
              </div>
            </div>

          </div>
        </div>

        <!-- Botones de acción -->
        <div class="d-flex gap-2">
          <button class="btn btn-outline-secondary flex-grow-1" id="btnCancelarPago">
            <i class="bi bi-x-circle me-1"></i> Cancelar
          </button>
          <button class="btn btn-warning flex-grow-1 fw-bold" id="btnRegistrarPago">
            <i class="bi bi-check-circle me-1"></i> Registrar pago
          </button>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- Modal de confirmación de pago exitoso -->
<div class="modal fade" id="modalPagoExito" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg text-center p-4">
      <div class="mb-3">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
      </div>
      <h4 class="fw-bold">¡Pago registrado!</h4>
      <div class="recibo-modal mt-3 text-start">
        <div class="recibo-fila">
          <span>Alumno</span><strong id="reciboNombre">–</strong>
        </div>
        <div class="recibo-fila">
          <span>Días comedor</span><strong id="reciboDias">–</strong>
        </div>
        <div class="recibo-fila">
          <span>Comedor</span><strong id="reciboComedor">–</strong>
        </div>
        <div class="recibo-fila">
          <span>Computación</span><strong id="reciboComputo">–</strong>
        </div>
        <hr>
        <div class="recibo-fila recibo-total">
          <span>Total</span><strong id="reciboTotal">–</strong>
        </div>
      </div>
      <button class="btn btn-warning px-5 mt-4" id="btnCerrarPagoExito">Aceptar</button>
    </div>
  </div>
</div>