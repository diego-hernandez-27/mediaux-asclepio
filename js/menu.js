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
            case 'Emergencia':
                alert('Ir a Emergencia');
                // window.location.href = 'emergencia.html';
                break;
            case 'Historial':
                alert('Ir a Historial');
                // window.location.href = 'historial.html';
                break;
            case 'Mapa':
                alert('Ir a Mapa');
                // window.location.href = 'mapa.html';
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

// Cargar datos del usuario al iniciar
document.addEventListener('DOMContentLoaded', function() {
    loadUserData();
    // Mostrar emergencias por defecto
    showEmergencySection();
});

// Función para cargar datos del usuario
function loadUserData() {
    const userData = JSON.parse(localStorage.getItem('userData')) || {};
    const usernameElement = document.querySelector('.username');
    
    if (usernameElement && userData.nombre) {
        usernameElement.textContent = userData.nombre;
    }
}

// Función para mostrar la sección de emergencias
function showEmergencySection() {
    hideAllSections();
    const emergencySection = document.getElementById('emergency-section');
    if (emergencySection) {
        emergencySection.style.display = 'block';
    }
}

// Función para mostrar la sección del mapa
function showMapSection() {
    hideAllSections();
    const mapSection = document.getElementById('map-section');
    if (mapSection) {
        mapSection.style.display = 'flex';
    }
}

// Función para mostrar la sección de historial
function showHistorialSection() {
    hideAllSections();
    const historialSection = document.getElementById('historial-section');
    if (historialSection) {
        historialSection.style.display = 'block';
    }
}

// Función para mostrar la sección de favoritos
function showFavoritosSection() {
    hideAllSections();
    const favoritosSection = document.getElementById('favoritos-section');
    if (favoritosSection) {
        favoritosSection.style.display = 'block';
    }
}

// Función para ocultar todas las secciones
function hideAllSections() {
    const sections = [
        'emergency-section',
        'map-section', 
        'historial-section',
        'favoritos-section'
    ];
    
    sections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'none';
        }
    });
}

// Función para manejar la búsqueda
function handleSearch() {
    const searchInput = document.querySelector('.search-bar input');
    const searchTerm = searchInput.value.trim();
    
    if (searchTerm) {
        // Simular búsqueda sin mostrar alert
        console.log('Buscando:', searchTerm);
        searchInput.value = '';
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Event listener para la búsqueda
    const searchBtn = document.querySelector('.search-btn');
    if (searchBtn) {
        searchBtn.addEventListener('click', handleSearch);
    }
    
    // Event listener para el input de búsqueda (Enter key)
    const searchInput = document.querySelector('.search-bar input');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleSearch();
            }
        });
    }
    
    // Event listener para el nombre de usuario (navegación al perfil)
    const usernameElement = document.querySelector('.username');
    if (usernameElement) {
        usernameElement.addEventListener('click', function() {
            window.location.href = 'perfil.html';
        });
    }
    
    // Event listener para doble clic en el logo (logout)
    const logoTitle = document.querySelector('.logo-title');
    if (logoTitle) {
        logoTitle.addEventListener('dblclick', function() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                localStorage.clear();
                window.location.href = 'login.html';
            }
        });
    }
}); 