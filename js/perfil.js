// Elementos del DOM
const userName = document.getElementById('user-name');
const userEmail = document.getElementById('user-email');
const fullName = document.getElementById('full-name');
const birthDate = document.getElementById('birth-date');
const phone = document.getElementById('phone');
const gender = document.getElementById('gender');
const street = document.getElementById('street');
const number = document.getElementById('number');
const colony = document.getElementById('colony');
const city = document.getElementById('city');
const state = document.getElementById('state');
const zip = document.getElementById('zip');

// Función para cargar datos del usuario
function loadUserData() {
    // Cargar nombre de usuario desde localStorage
    const savedUsername = localStorage.getItem('username');
    if (savedUsername) {
        userName.textContent = savedUsername;
        fullName.textContent = savedUsername + ' Apellido';
        userEmail.textContent = savedUsername.toLowerCase() + '@email.com';
    }
    
    // Aquí podrías cargar más datos desde localStorage o una API
    // Por ahora usamos datos de ejemplo
}

// Función para cerrar sesión
function logout() {
    if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
        // Limpiar datos del usuario
        localStorage.removeItem('username');
        
        // Mostrar mensaje de confirmación
        showNotification('Sesión cerrada exitosamente', 'success');
        
        // Redirigir al login después de un breve delay
        setTimeout(() => {
            window.location.href = 'login.html';
        }, 1500);
    }
}

// Funcionalidad para los botones de acción
document.addEventListener('DOMContentLoaded', () => {
    loadUserData();
    
    // Botón Editar Perfil
    document.querySelector('.edit-btn').addEventListener('click', () => {
        showNotification('Función de edición en desarrollo', 'info');
        // Aquí iría la lógica para editar el perfil
    });
    
    // Botón Cambiar Contraseña
    document.querySelector('.password-btn').addEventListener('click', () => {
        showNotification('Función de cambio de contraseña en desarrollo', 'info');
        // Aquí iría la lógica para cambiar contraseña
    });
    
    // Botón Preferencias
    document.querySelector('.preferences-btn').addEventListener('click', () => {
        showNotification('Función de preferencias en desarrollo', 'info');
        // Aquí iría la lógica para configurar preferencias
    });
    
    // Avatar overlay (cambiar foto)
    document.querySelector('.avatar-overlay').addEventListener('click', () => {
        showNotification('Función de cambio de foto en desarrollo', 'info');
        // Aquí iría la lógica para cambiar la foto de perfil
    });
    
    // Efecto de carga de la página
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

// Función para mostrar notificaciones
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        background-color: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#2196F3'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Agregar estilos CSS para las animaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Función para actualizar estadísticas (ejemplo)
function updateStats() {
    // Aquí podrías cargar estadísticas reales desde una API
    const stats = {
        appointments: Math.floor(Math.random() * 20) + 5,
        hospitals: Math.floor(Math.random() * 10) + 2,
        doctors: Math.floor(Math.random() * 15) + 3,
        specialties: Math.floor(Math.random() * 5) + 1
    };
    
    document.querySelector('.stat-item:nth-child(1) .stat-number').textContent = stats.appointments;
    document.querySelector('.stat-item:nth-child(2) .stat-number').textContent = stats.hospitals;
    document.querySelector('.stat-item:nth-child(3) .stat-number').textContent = stats.doctors;
    document.querySelector('.stat-item:nth-child(4) .stat-number').textContent = stats.specialties;
}

// Llamar a la función de estadísticas al cargar la página
document.addEventListener('DOMContentLoaded', updateStats); 