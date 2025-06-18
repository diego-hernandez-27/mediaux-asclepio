// Elementos del DOM
const searchInput = document.querySelector('.search-bar input');
const searchBtn = document.querySelector('.search-btn');
const menuIcons = document.querySelectorAll('.icon');
const username = document.querySelector('.username');

// Función de búsqueda
function performSearch() {
    const searchTerm = searchInput.value.trim();
    if (searchTerm) {
        console.log('Buscando:', searchTerm);
        // Aquí puedes agregar la lógica de búsqueda
        alert(`Buscando: ${searchTerm}`);
    } else {
        alert('Por favor ingresa un término de búsqueda');
    }
}

// Event listeners
searchBtn.addEventListener('click', performSearch);

searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        performSearch();
    }
});

// Funcionalidad para los iconos del menú
menuIcons.forEach(icon => {
    icon.addEventListener('click', () => {
        const iconName = icon.querySelector('p').textContent;
        console.log('Icono clickeado:', iconName);
        
        // Aquí puedes agregar la navegación a diferentes secciones
        switch(iconName) {
            case 'Notas':
                alert('Ir a Notas');
                // window.location.href = 'notas.html';
                break;
            case 'Historial':
                alert('Ir a Historial');
                // window.location.href = 'historial.html';
                break;
            case 'Mapa':
                alert('Ir a Mapa');
                // window.location.href = 'mapa.html';
                break;
            case 'Nube':
                alert('Ir a Nube');
                // window.location.href = 'nube.html';
                break;
            case 'Favoritos':
                alert('Ir a Favoritos');
                // window.location.href = 'favoritos.html';
                break;
        }
    });
});

// Funcionalidad para el perfil de usuario
username.addEventListener('click', () => {
    console.log('Perfil de usuario clickeado');
    // Navegar al perfil
    window.location.href = 'perfil.html';
});

// Cargar nombre de usuario desde localStorage (si existe)
function loadUserData() {
    const savedUsername = localStorage.getItem('username');
    if (savedUsername) {
        username.textContent = savedUsername;
    }
}

// Función para cerrar sesión
function logout() {
    localStorage.removeItem('username');
    window.location.href = 'login.html';
}

// Agregar funcionalidad de logout al hacer doble clic en el username
username.addEventListener('dblclick', () => {
    if (confirm('¿Deseas cerrar sesión?')) {
        logout();
    }
});

// Inicializar la página
document.addEventListener('DOMContentLoaded', () => {
    loadUserData();
    
    // Agregar efecto de carga
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
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
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