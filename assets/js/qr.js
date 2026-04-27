document.getElementById("btnGenerar").addEventListener("click", function () {
    let form = document.getElementById("formAlumno");
    let datos = new FormData(form);

    fetch("generar_qr.php", {
        method: "POST",
        body: datos
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {

                document.getElementById("mensaje").innerHTML =
                    "<div class='alert alert-success'>QR generado correctamente</div>";

                setTimeout(() => {
                    form.reset();

                    let modalElement = document.getElementById('modalIndividual');
                    let modal = bootstrap.Modal.getInstance(modalElement);

                    if (!modal) {
                        modal = new bootstrap.Modal(modalElement);
                    }

                    modal.hide();

                    // limpiar mensaje después
                    document.getElementById("mensaje").innerHTML = "";

                }, 2000);
            }
        });
});