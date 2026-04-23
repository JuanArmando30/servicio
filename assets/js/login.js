document.getElementById('togglePassword').addEventListener('click', function() {
  const passwordInput = document.getElementById('passwordInput');
  const icon = document.getElementById('togglePassword');
  
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    icon.textContent = 'visibility_off'; // Cambia el ícono para ocultar la contraseña
  } else {
    passwordInput.type = 'password';
    icon.textContent = 'visibility'; // Cambia el ícono para mostrar la contraseña
  }
});

/* MODAL DE ERROR DE SESION */

const ventana = document.getElementById("ventanaError");

function mostrarError() {
    ventana.classList.remove("ocultar");
    ventana.classList.add("mostrar");
}

ventana.addEventListener('click', function() {
  ventana.classList.remove("mostrar");
  ventana.classList.add("ocultar");
});

ventana.addEventListener("transitionend", () => {
    if (ventana.classList.contains("ocultar")) {
        document.getElementById('contentMensaje').classList.add("ocultar_content");
    }
});