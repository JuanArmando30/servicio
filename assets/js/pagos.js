document.addEventListener("DOMContentLoaded", function () {

    // Estado global
    let alumnoActual = null;
    let semanaActual = null;
    let streamCamara = null;

    const PRECIO_COMEDOR = 20;
    const PRECIO_COMPUTO = 15;
    const DESCUENTO_DIA = 3;

    // Referencias DOM
    const inputCodigo = document.getElementById("inputCodigo");
    const btnBuscar = document.getElementById("btnBuscar");
    const errorBusqueda = document.getElementById("errorBusqueda");
    const panelVacio = document.getElementById("panelVacio");
    const panelPago = document.getElementById("panelPago");
    const checkboxes = document.querySelectorAll("input[name='dia']");

    // Buscar alumno por código
    function buscarAlumno(codigo) {
        errorBusqueda.style.display = "none";

        fetch(`/SERVICIO/paginas/pagos/buscar_alumno.php?codigo=${encodeURIComponent(codigo)}`)
            .then(res => res.json())
            .then(data => {
                if (data.status !== "ok") {
                    errorBusqueda.textContent = data.mensaje || "Alumno no encontrado.";
                    errorBusqueda.style.display = "block";
                    return;
                }

                alumnoActual = data.alumno;
                semanaActual = data.semana;

                // Rellenar tarjeta de alumno
                document.getElementById("pagoNombre").textContent = alumnoActual.nombre;
                document.getElementById("pagoGrado").textContent = alumnoActual.grado || "–";
                document.getElementById("pagoGrupo").textContent = alumnoActual.grupo || "–";
                document.getElementById("pagoSemana").textContent = formatearSemana(semanaActual);

                // Si ya tiene pago esta semana, pre-marcar los días
                resetDias();
                if (data.pago) {
                    ["lunes", "martes", "miercoles", "jueves", "viernes"].forEach(dia => {
                        if (data.pago[dia] == 1) {
                            document.getElementById(`chk-${dia}`).checked = true;
                        }
                    });
                }

                actualizarResumen();
                mostrarPanelPago();
            })
            .catch(err => {
                errorBusqueda.textContent = "Error de conexión.";
                errorBusqueda.style.display = "block";
                console.error(err);
            });
    }

    // Calcular y actualizar resumen en tiempo real
    function actualizarResumen() {
        let dias = 0;
        checkboxes.forEach(chk => { if (chk.checked) dias++; });

        const costoComedor = dias * PRECIO_COMEDOR;
        const costoComputo = Math.max(0, PRECIO_COMPUTO - (dias * DESCUENTO_DIA));
        const total = costoComedor + costoComputo;
        const pctDescuento = Math.min(100, Math.round((dias * DESCUENTO_DIA / PRECIO_COMPUTO) * 100));

        document.getElementById("resDias").textContent = `${dias} día(s)`;
        document.getElementById("resDiasCobro").textContent = dias;
        document.getElementById("resComedor").textContent = `$${costoComedor.toFixed(2)}`;
        document.getElementById("resComputo").textContent = `$${costoComputo.toFixed(2)}`;
        document.getElementById("resTotal").textContent = `$${total.toFixed(2)}`;
        document.getElementById("resDescuentoPct").textContent = `${pctDescuento}%`;
        document.getElementById("barraDescuento").style.width = `${pctDescuento}%`;

        const descTexto = dias > 0
            ? `(−$${(dias * DESCUENTO_DIA).toFixed(2)} por ${dias} día(s))`
            : '';
        document.getElementById("resDescuento").textContent = descTexto;
    }

    // Registrar pago
    function registrarPago() {
        if (!alumnoActual) return;

        const payload = {
            alumno_id: alumnoActual.id,
            semana: semanaActual,
            lunes: document.getElementById("chk-lunes").checked ? 1 : 0,
            martes: document.getElementById("chk-martes").checked ? 1 : 0,
            miercoles: document.getElementById("chk-miercoles").checked ? 1 : 0,
            jueves: document.getElementById("chk-jueves").checked ? 1 : 0,
            viernes: document.getElementById("chk-viernes").checked ? 1 : 0
        };

        fetch("/SERVICIO/paginas/pagos/registrar_pago.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        })
            .then(res => res.json())
            .then(data => {
                if (data.status !== "ok") {
                    alert("Error al registrar: " + (data.mensaje || ""));
                    return;
                }

                // Rellenar recibo del modal
                document.getElementById("reciboNombre").textContent = alumnoActual.nombre;
                document.getElementById("reciboDias").textContent = `${data.dias_comedor} día(s)`;
                document.getElementById("reciboComedor").textContent = `$${parseFloat(data.costo_comedor).toFixed(2)}`;
                document.getElementById("reciboComputo").textContent = `$${parseFloat(data.costo_computo).toFixed(2)}`;
                document.getElementById("reciboTotal").textContent = `$${parseFloat(data.total).toFixed(2)}`;

                // Mostrar modal de éxito
                const modal = new bootstrap.Modal(document.getElementById("modalPagoExito"));
                modal.show();

                document.getElementById("btnCerrarPagoExito").onclick = function () {
                    modal.hide();
                    cancelarPago(); // Limpiar para siguiente alumno
                };
            })
            .catch(err => {
                console.error("Error registrando pago:", err);
                alert("Error de conexión.");
            });
    }

    // Utilidades
    function mostrarPanelPago() {
        panelVacio.style.display = "none";
        panelPago.style.removeProperty("display"); // quita el !important inline
        panelPago.style.setProperty("display", "flex", "important");
        panelPago.style.flexDirection = "column";
    }

    function cancelarPago() {
        alumnoActual = null;
        semanaActual = null;
        inputCodigo.value = "";
        resetDias();
        panelVacio.style.display = "block";
        panelPago.style.display = "none";
    }

    function resetDias() {
        checkboxes.forEach(chk => chk.checked = false);
        actualizarResumen();
    }

    function formatearSemana(fechaLunes) {
        const lunes = new Date(fechaLunes + "T12:00:00");
        const viernes = new Date(lunes);
        viernes.setDate(lunes.getDate() + 4);
        const opts = { day: '2-digit', month: 'short' };
        return `${lunes.toLocaleDateString('es-MX', opts)} – ${viernes.toLocaleDateString('es-MX', opts)}`;
    }

    // Cámara QR
    document.getElementById("btnActivarCamara").addEventListener("click", function () {
        document.getElementById("scannerPlaceholder").style.display = "none";
        document.getElementById("scannerActivo").style.display = "block";

        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then(stream => {
                streamCamara = stream;
                const video = document.getElementById("videoQR");
                video.srcObject = stream;
                video.play();
                escanearFrame(video);
            })
            .catch(() => {
                alert("No se pudo acceder a la cámara. Usa el campo manual.");
                document.getElementById("scannerPlaceholder").style.display = "flex";
                document.getElementById("scannerActivo").style.display = "none";
            });
    });

    document.getElementById("btnDetenerCamara").addEventListener("click", detenerCamara);

    function detenerCamara() {
        if (streamCamara) {
            streamCamara.getTracks().forEach(t => t.stop());
            streamCamara = null;
        }
        document.getElementById("scannerPlaceholder").style.display = "flex";
        document.getElementById("scannerActivo").style.display = "none";
    }

    function escanearFrame(video) {
        // Usar BarcodeDetector nativo si está disponible
        if (!("BarcodeDetector" in window)) return;

        const detector = new BarcodeDetector({ formats: ["qr_code"] });

        function tick() {
            if (!streamCamara) return;
            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                detector.detect(video).then(codigos => {
                    if (codigos.length > 0) {
                        const codigo = codigos[0].rawValue;
                        detenerCamara();
                        inputCodigo.value = codigo;
                        buscarAlumno(codigo);
                    }
                }).catch(() => { });
            }
            requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    // Eventos
    btnBuscar.addEventListener("click", () => {
        const codigo = inputCodigo.value.trim();
        if (codigo) buscarAlumno(codigo);
    });

    inputCodigo.addEventListener("keydown", e => {
        if (e.key === "Enter") btnBuscar.click();
    });

    checkboxes.forEach(chk => {
        chk.addEventListener("change", actualizarResumen);
    });

    document.getElementById("btnRegistrarPago").addEventListener("click", registrarPago);
    document.getElementById("btnCancelarPago").addEventListener("click", cancelarPago);
});