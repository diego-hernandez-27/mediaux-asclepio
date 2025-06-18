const inputUsuario = document.getElementById('input-usuario');
const inputNombre = document.getElementById('input-nombre');
const inputApellidoPaterno = document.getElementById('input-apellido-paterno');
const inputApellidoMaterno = document.getElementById('input-apellido-materno');
const inputCorreo = document.getElementById('input-correo');
const inputTelefono = document.getElementById('input-telefono');
const inputFechaNacimiento = document.getElementById('input-fecha-nacimiento');
const inputContrasena = document.getElementById('input-contrasena');
const inputCalle = document.getElementById('input-calle');
const inputNumero = document.getElementById('input-numero');
const inputColonia = document.getElementById('input-colonia');
const inputCiudad = document.getElementById('input-ciudad');
const inputEstado = document.getElementById('input-estado');
const inputCodigoPostal = document.getElementById('input-codigo-postal');

// Evento para el formulario
document.querySelector('.formulario').addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Validación básica
    if (!inputUsuario.value || !inputNombre.value || !inputContrasena.value) {
        alert('Por favor completa los campos obligatorios');
        return;
    }
    
    // Validación de correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(inputCorreo.value)) {
        alert('Por favor ingresa un correo electrónico válido');
        return;
    }
    
    // Validación de contraseña (mínimo 6 caracteres)
    if (inputContrasena.value.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres');
        return;
    }
    
    // Aquí iría la lógica para enviar los datos al servidor
    console.log('Formulario enviado');
    alert('Registro exitoso!');
});

// Validación en tiempo real para campos requeridos
function validarCampo(input, nombreCampo) {
    if (!input.value.trim()) {
        input.style.borderColor = '#ff6b6b';
        return false;
    } else {
        input.style.borderColor = '#37869e';
        return true;
    }
}

// Agregar validación en tiempo real a campos obligatorios
inputUsuario.addEventListener('blur', () => validarCampo(inputUsuario, 'usuario'));
inputNombre.addEventListener('blur', () => validarCampo(inputNombre, 'nombre'));
inputCorreo.addEventListener('blur', () => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(inputCorreo.value)) {
        inputCorreo.style.borderColor = '#ff6b6b';
    } else {
        inputCorreo.style.borderColor = '#37869e';
    }
});
inputContrasena.addEventListener('blur', () => {
    if (inputContrasena.value.length < 6) {
        inputContrasena.style.borderColor = '#ff6b6b';
    } else {
        inputContrasena.style.borderColor = '#37869e';
    }
}); 