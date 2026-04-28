document.addEventListener("DOMContentLoaded", function () {

    // Cargar estadísticas de seguimiento
    function cargarEstadisticas() {
        fetch("/SERVICIO/paginas/qr/estadisticas_qr.php")
            .then(res => res.json())
            .then(data => {
                if (data.status === "ok") {
                    document.getElementById("statTotal").textContent = data.total;
                    document.getElementById("statHoy").textContent = data.hoy;
                    document.getElementById("statUltimo").textContent = data.ultimo;
                }
            })
            .catch(err => console.error("Error estadísticas:", err));
    }

    // Cargar al entrar a la página
    cargarEstadisticas();

    // Mostrar modal de éxito
    function mostrarExito(titulo, mensaje) {
        document.getElementById("exitoTitulo").textContent = titulo;
        document.getElementById("exitoMensaje").textContent = mensaje;

        const modalExito = new bootstrap.Modal(document.getElementById("modalExito"));
        modalExito.show();

        document.getElementById("btnCerrarExito").onclick = function () {
            modalExito.hide();
        };
    }

    // QR INDIVIDUAL
    const btnGenerar = document.getElementById("btnGenerar");
    if (btnGenerar) {
        btnGenerar.addEventListener("click", function () {
            const form = document.getElementById("formAlumno");
            const datos = new FormData(form);

            fetch("/SERVICIO/paginas/qr/generar_qr.php", {
                method: "POST",
                body: datos
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "ok") {

                        // Cerrar modal del formulario
                        const modalForm = bootstrap.Modal.getInstance(
                            document.getElementById("modalIndividual")
                        );
                        if (modalForm) modalForm.hide();

                        // Limpiar formulario
                        form.reset();

                        // Mostrar éxito
                        mostrarExito(
                            "¡QR Generado!",
                            "El código QR fue creado correctamente."
                        );

                    } else {
                        alert("Ocurrió un error al generar el QR.");
                    }
                })
                .catch(err => console.error("Error individual:", err));
        });
    }

    // QR MASIVO (Excel)
    const btnProcesar = document.getElementById("btnProcesarExcel");
    if (btnProcesar) {
        btnProcesar.addEventListener("click", function () {

            const archivoInput = document.getElementById("archivoExcel");

            // Validar que se seleccionó un archivo
            if (!archivoInput.files.length) {
                alert("Por favor selecciona un archivo Excel.");
                return;
            }

            const datos = new FormData();
            datos.append("archivo", archivoInput.files[0]);

            // Mostrar barra de progreso y deshabilitar botones
            document.getElementById("progresoExcel").style.display = "block";
            btnProcesar.disabled = true;
            document.getElementById("btnCancelarExcel").disabled = true;

            fetch("/SERVICIO/paginas/qr/generar_qr_masivo.php", {
                method: "POST",
                body: datos
            })
                .then(res => res.json())
                .then(data => {

                    // Ocultar progreso y reactivar botones
                    document.getElementById("progresoExcel").style.display = "none";
                    btnProcesar.disabled = false;
                    document.getElementById("btnCancelarExcel").disabled = false;

                    if (data.status === "ok") {

                        // Cerrar modal del Excel
                        const modalExcel = bootstrap.Modal.getInstance(
                            document.getElementById("modalExcel")
                        );
                        if (modalExcel) modalExcel.hide();

                        // Limpiar el input de archivo
                        archivoInput.value = "";

                        // Construir mensaje según resultados
                        let mensaje = `Se generaron ${data.generados} código(s) QR correctamente.`;
                        if (data.errores > 0) {
                            mensaje += ` (${data.errores} fila(s) no pudieron procesarse)`;
                        }

                        // Mostrar éxito
                        mostrarExito("¡QRs Generados!", mensaje);

                    } else {
                        alert("Error: " + (data.mensaje || "No se pudo procesar el archivo."));
                    }
                })
                .catch(err => {
                    console.error("Error masivo:", err);
                    document.getElementById("progresoExcel").style.display = "none";
                    btnProcesar.disabled = false;
                    document.getElementById("btnCancelarExcel").disabled = false;
                    alert("Ocurrió un error de conexión.");
                });
        });
    }

});