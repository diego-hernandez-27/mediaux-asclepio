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
        
        // Navegación directa a diferentes secciones sin alertas
        switch(iconName) {
            case 'Emergencia':
                showEmergencySection();
                break;
            case 'Historial':
                showHistorialSection();
                break;
            case 'Mapa':
                showMapSection();
                break;
            case 'Favoritos':
                showFavoritosSection();
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
    
    // Event listener para el formulario de incidente
    const incidentForm = document.querySelector('.incident-form');
    if (incidentForm) {
        incidentForm.addEventListener('submit', handleIncidentSubmit);
    }
});

// Función para manejar el envío del formulario de incidente
function handleIncidentSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const incidentData = {
        paciente: formData.get('paciente'),
        edad: formData.get('edad'),
        sintomas: formData.get('sintomas'),
        diagnostico: formData.get('diagnostico'),
        tratamiento: formData.get('tratamiento'),
        estado: formData.get('estado'),
        fecha: new Date().toISOString()
    };
    
    // Validar campos requeridos
    if (!incidentData.paciente || !incidentData.edad || !incidentData.sintomas || !incidentData.estado) {
        showNotification('Por favor completa todos los campos requeridos', 'error');
        return;
    }
    
    // Simular envío (aquí se conectaría con el backend)
    console.log('Datos del incidente:', incidentData);
    
    // Mostrar notificación de éxito
    showNotification('Incidente registrado exitosamente', 'success');
    
    // Limpiar formulario
    e.target.reset();
    
    // Opcional: Guardar en localStorage para historial local
    saveIncidentToHistory(incidentData);
}

// Función para guardar incidente en el historial local
function saveIncidentToHistory(incidentData) {
    let history = JSON.parse(localStorage.getItem('incidentHistory') || '[]');
    history.push(incidentData);
    localStorage.setItem('incidentHistory', JSON.stringify(history));
}

// Función para quitar de favoritos
function removeFromFavorites(itemId) {
    // Simular remoción de favoritos
    console.log('Removiendo de favoritos:', itemId);
    
    // Mostrar notificación
    showNotification('Removido de favoritos', 'success');
    
    // Aquí se podría actualizar la UI para remover la tarjeta
    // Por ahora solo cerramos el dropdown
    const dropdown = document.getElementById(`dropdown-${itemId}-fav`);
    if (dropdown) {
        dropdown.style.display = 'none';
    }
}

// Función para mostrar opciones adicionales (actualizada para favoritos)
function showMoreOptions(itemId) {
    // Cerrar todos los dropdowns primero
    const allDropdowns = document.querySelectorAll('.dropdown-menu');
    allDropdowns.forEach(dropdown => {
        dropdown.style.display = 'none';
    });
    
    // Mostrar el dropdown específico
    const dropdown = document.getElementById(`dropdown-${itemId}`);
    if (dropdown) {
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }
}

// Cerrar dropdowns al hacer clic fuera de ellos
document.addEventListener('click', function(event) {
    if (!event.target.closest('.more-options')) {
        const allDropdowns = document.querySelectorAll('.dropdown-menu');
        allDropdowns.forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    }
});

// Función para descargar emergencia
function downloadEmergency(itemId) {
    console.log('Descargando emergencia:', itemId);
    showNotification('Descargando información...', 'info');
    
    // Simular descarga
    setTimeout(() => {
        showNotification('Descarga completada', 'success');
    }, 2000);
}

// Función para alternar favorito
function toggleFavorite(itemId) {
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    const favoriteIcon = document.getElementById(`favorite-${itemId}`);
    
    if (favorites.includes(itemId)) {
        // Remover de favoritos
        favorites = favorites.filter(id => id !== itemId);
        favoriteIcon.textContent = '🤍';
        showNotification('Removido de favoritos', 'success');
    } else {
        // Agregar a favoritos
        favorites.push(itemId);
        favoriteIcon.textContent = '❤️';
        showNotification('Agregado a favoritos', 'success');
    }
    
    localStorage.setItem('favorites', JSON.stringify(favorites));
}

// Función para navegar al detalle de emergencia
function openEmergencyDetail(itemId) {
    window.location.href = `emergency-detail.html?id=${itemId}`;
}

// Función para compartir emergencia
function shareEmergency(itemId) {
    const emergencyTitles = {
        'rcp': 'Reanimación Cardiopulmonar (RCP)',
        'hemorragia': 'Control de Hemorragias',
        'quemaduras': 'Primeros Auxilios en Quemaduras',
        'ahogamiento': 'Rescate por Ahogamiento',
        'fracturas': 'Inmovilización de Fracturas',
        'ataque-cardiaco': 'Síntomas de Ataque Cardíaco'
    };
    
    const title = emergencyTitles[itemId] || 'Emergencia Médica';
    const url = `${window.location.origin}${window.location.pathname.replace('menu.html', 'emergency-detail.html')}?id=${itemId}`;
    
    if (navigator.share) {
        navigator.share({
            title: title,
            text: 'Información importante sobre emergencias médicas',
            url: url
        }).then(() => {
            showNotification('Compartido exitosamente', 'success');
        }).catch(() => {
            showNotification('Error al compartir', 'error');
        });
    } else {
        navigator.clipboard.writeText(url).then(() => {
            showNotification('URL copiada al portapapeles', 'success');
        }).catch(() => {
            showNotification('Error al copiar URL', 'error');
        });
    }
}

// Función para reportar emergencia
function reportEmergency(itemId) {
    console.log('Reportando emergencia:', itemId);
    showNotification('Reporte enviado', 'success');
}

// Función para abrir el chat IA
function openChatIA() {
    const modal = document.getElementById('chat-modal');
    modal.style.display = 'block';
    document.getElementById('chat-input').focus();
}

// Función para cerrar el chat IA
function closeChatIA() {
    const modal = document.getElementById('chat-modal');
    modal.style.display = 'none';
}

// Función para manejar la tecla Enter en el input
function handleChatInput(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('click', function(event) {
    const modal = document.getElementById('chat-modal');
    const chatBtn = document.querySelector('.chat-ia-btn');
    
    if (event.target === modal) {
        closeChatIA();
    }
}); 