document.addEventListener("DOMContentLoaded", function () {

    const filtroNombre = document.getElementById("filtroNombre");
    const filtroGrado  = document.getElementById("filtroGrado");
    const filtroGrupo  = document.getElementById("filtroGrupo");
    const btnLimpiar   = document.getElementById("btnLimpiarFiltros");

    let debounceTimer = null; // Para no disparar fetch en cada tecla

    // ── Cargar alumnos con filtros actuales ──────────────────────
    function cargarAlumnos() {
        const params = new URLSearchParams({
            nombre: filtroNombre.value.trim(),
            grado:  filtroGrado.value,
            grupo:  filtroGrupo.value
        });

        // Mostrar spinner, ocultar tabla y vacío
        document.getElementById("estadoCarga").style.display    = "block";
        document.getElementById("contenedorTabla").style.display = "none";
        document.getElementById("estadoVacio").style.display    = "none";

        fetch(`/SERVICIO/paginas/alumnos/obtener_alumnos.php?${params}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById("estadoCarga").style.display = "none";

            if (data.status !== "ok") return;

            // Actualizar contador
            document.getElementById("totalAlumnos").textContent = data.total;

            // Poblar selectores de grado y grupo (solo primera carga)
            poblarSelect(filtroGrado, data.grados);
            poblarSelect(filtroGrupo, data.grupos);

            if (data.total === 0) {
                document.getElementById("estadoVacio").style.display = "block";
                return;
            }

            // Renderizar filas
            const tbody = document.getElementById("tablaBody");
            tbody.innerHTML = "";

            data.alumnos.forEach((alumno, index) => {
                const qrHtml = alumno.codigo_qr
                    ? `<span class="badge-qr">${alumno.codigo_qr.substring(0, 12)}</span>`
                    : `<span class="badge-sin-qr">Sin QR</span>`;

                const fecha = alumno.fecha_registro
                    ? formatearFecha(alumno.fecha_registro)
                    : '–';

                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td><span class="nombre-alumno">${alumno.nombre}</span></td>
                        <td><span class="badge-grado">${alumno.grado || '–'}</span></td>
                        <td><span class="badge-grupo">${alumno.grupo || '–'}</span></td>
                        <td>${qrHtml}</td>
                        <td><span class="fecha-registro">${fecha}</span></td>
                    </tr>`;
            });

            document.getElementById("contenedorTabla").style.display = "block";
        })
        .catch(err => {
            console.error("Error cargando alumnos:", err);
            document.getElementById("estadoCarga").style.display = "none";
        });
    }

    // ── Poblar select sin duplicar opciones ──────────────────────
    function poblarSelect(selectEl, valores) {
        // Si ya tiene opciones cargadas (más de la opción "Todos"), saltar
        if (selectEl.options.length > 1) return;

        valores.forEach(val => {
            const opt = document.createElement("option");
            opt.value       = val;
            opt.textContent = val;
            selectEl.appendChild(opt);
        });
    }

    // ── Formatear fecha legible ───────────────────────────────────
    function formatearFecha(fechaStr) {
        const fecha = new Date(fechaStr);
        return fecha.toLocaleDateString('es-MX', {
            day:   '2-digit',
            month: 'short',
            year:  'numeric'
        });
    }

    // ── Eventos de filtros ────────────────────────────────────────

    // Nombre: espera 400ms después de que el usuario deja de escribir
    filtroNombre.addEventListener("input", function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(cargarAlumnos, 400);
    });

    // Selects: respuesta inmediata
    filtroGrado.addEventListener("change", cargarAlumnos);
    filtroGrupo.addEventListener("change", cargarAlumnos);

    // Limpiar filtros
    btnLimpiar.addEventListener("click", function () {
        filtroNombre.value = "";
        filtroGrado.value  = "";
        filtroGrupo.value  = "";
        cargarAlumnos();
    });

    // ── Carga inicial ─────────────────────────────────────────────
    cargarAlumnos();
});