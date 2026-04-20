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