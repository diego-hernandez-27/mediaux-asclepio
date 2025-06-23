let emergencyData = {};
let currentEmergency = null;
let isFavorite = false;

// Función para obtener parámetros de la URL
function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Cargar datos desde data.json y luego la emergencia específica
function loadEmergencyData() {
    let emergencyId = getUrlParameter('id');

    if (!emergencyId) {
        emergencyId = localStorage.getItem("casoSeleccionado");
        if (!emergencyId) {
            console.warn("Ni ID en la URL ni casoSeleccionado. Redirigiendo...");
            window.location.href = 'menu.html';
            return;
        }
    }

    // No borres el caso seleccionado inmediatamente
    currentEmergency = emergencyData[emergencyId];
    if (!currentEmergency) {
        console.error("ID inválido:", emergencyId);
        window.location.href = 'menu.html';
        return;
    }

    // Solo guardamos el caso si vino desde la URL
    if (getUrlParameter('id')) {
        localStorage.setItem("casoSeleccionado", emergencyId);
    }

    loadUserData();
    updatePageContent();
    checkFavoriteStatus(emergencyId);
}


// Función para actualizar el contenido de la página
function updatePageContent() {
    if (!currentEmergency) return;

    document.getElementById('emergency-icon').src = currentEmergency.icono;
    document.getElementById('emergency-badge').textContent = currentEmergency.badge;
    document.getElementById('emergency-title').textContent = currentEmergency.titulo;
    document.getElementById('emergency-description').textContent = currentEmergency.descripcion;
    document.getElementById('emergency-image').src = currentEmergency.imagen;

    const stepsList = document.getElementById('precautions-steps');
    stepsList.innerHTML = '';
    currentEmergency.pasos.forEach(paso => {
        const li = document.createElement('li');
        li.textContent = paso;
        stepsList.appendChild(li);
    });

    document.getElementById('precautions-summary').textContent = currentEmergency.resumen;
    document.getElementById('source-text').textContent = currentEmergency.fuente;
    document.getElementById('page-number').textContent = currentEmergency.pagina;
    document.getElementById('file-link').href = currentEmergency.archivo;
    document.getElementById('time-estimate').textContent = currentEmergency.tiempo;
    document.getElementById('difficulty').textContent = currentEmergency.dificultad;
}

// Cargar datos del usuario
function loadUserData() {
    const userData = JSON.parse(localStorage.getItem('userData')) || {};
    const usernameElement = document.querySelector('.username');
    if (usernameElement && userData.nombre) {
        usernameElement.textContent = userData.nombre;
    }
}

// Verificar si está en favoritos
function checkFavoriteStatus(emergencyId) {
    const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    isFavorite = favorites.includes(emergencyId);
    updateFavoriteButton();
}

// Actualizar botón de favoritos
function updateFavoriteButton() {
    const favoriteIcon = document.getElementById('favorite-icon');
    const favoriteBtn = document.querySelector('.favorite-btn');

    if (isFavorite) {
        favoriteIcon.textContent = '❤️';
        favoriteBtn.classList.add('active');
    } else {
        favoriteIcon.textContent = '🤍';
        favoriteBtn.classList.remove('active');
    }
}

// Alternar favorito
function toggleFavorite() {
    if (!currentEmergency) return;

    const emergencyId = getUrlParameter('id') || localStorage.getItem("casoSeleccionado");
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

    if (isFavorite) {
        favorites = favorites.filter(id => id !== emergencyId);
        showNotification('Removido de favoritos', 'success');
    } else {
        favorites.push(emergencyId);
        showNotification('Agregado a favoritos', 'success');
    }

    localStorage.setItem('favorites', JSON.stringify(favorites));
    isFavorite = !isFavorite;
    updateFavoriteButton();
}

// Descargar
function downloadEmergency() {
    if (!currentEmergency) return;
    showNotification('Descargando información...', 'info');
    setTimeout(() => {
        showNotification('Descarga completada', 'success');
    }, 2000);
}

// Compartir
function shareEmergency() {
    if (!currentEmergency) return;

    if (navigator.share) {
        navigator.share({
            title: currentEmergency.titulo,
            text: currentEmergency.descripcion,
            url: window.location.href
        }).then(() => {
            showNotification('Compartido exitosamente', 'success');
        }).catch(() => {
            showNotification('Error al compartir', 'error');
        });
    } else {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification('URL copiada al portapapeles', 'success');
        }).catch(() => {
            showNotification('Error al copiar URL', 'error');
        });
    }
}

// Volver
function goBack() {
    window.location.href = 'menu.html';
}

// Notificación
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

// Estilos animación
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

// DOM Ready
document.addEventListener('DOMContentLoaded', function () {
    fetch("data.json")
        .then(res => res.json())
        .then(json => {
            emergencyData = json;
            loadEmergencyData();
        })
        .catch(err => {
            console.error("Error al cargar data.json:", err);
            showNotification("Error cargando datos. Intenta más tarde.", "error");
        });

    const usernameElement = document.querySelector('.username');
    if (usernameElement) {
        usernameElement.addEventListener('click', () => window.location.href = 'perfil.html');
    }

    const logoTitle = document.querySelector('.logo-title');
    if (logoTitle) {
        logoTitle.addEventListener('dblclick', () => {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                localStorage.clear();
                window.location.href = 'login.html';
            }
        });
    }

    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});
