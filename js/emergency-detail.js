// Datos de emergencias (simulando el JSON proporcionado)
const emergencyData = {
    'rcp': {
        titulo: 'Reanimación Cardiopulmonar (RCP)',
        descripcion: 'Técnica de emergencia para salvar vidas cuando alguien ha dejado de respirar o su corazón ha dejado de latir.',
        icono: 'https://img.icons8.com/color/96/heart-with-pulse.png',
        imagen: 'assets/primeros-auxilios-enfermeria.png',
        badge: 'CRÍTICO',
        tiempo: '2-3 min',
        dificultad: 'Fácil',
        precauciones: {
            titulo: 'Precauciones',
            categoria: 'Medidas importantes',
            descripcion: 'Las emergencias médicas pueden ocurrir todos los días y en cualquier entorno. Las personas pueden lesionarse en situaciones como caídas o accidentes de vehículos a motor, o desarrollar enfermedades repentinas como ataques al corazón o derrames cerebrales.\n\nLas estadísticas muestran que cerca de 900,000 personas en EE. UU. mueren cada año por enfermedades del corazón, siendo los paros cardíacos repentinos responsables de más de 300,000 de esas muertes. Además, en 2008 unas 118,000 personas murieron por lesiones no intencionadas y 25.7 millones quedaron discapacitadas.\n\nDado el gran número de lesiones y enfermedades repentinas, es probable que cualquier persona se enfrente a una emergencia en algún momento. Es fundamental saber a quién llamar, cuándo hacerlo y cómo ayudar hasta que llegue la asistencia médica.',
            pasos: [
                'Advertir que hay una emergencia',
                'Decidir actuar',
                'Activar el sistema de servicios médicos de emergencia',
                'Atender hasta que llegue la ayuda'
            ],
            resumen: 'Las emergencias médicas ocurren de forma inesperada. Estar preparado para reconocerlas, actuar con decisión, activar el sistema de emergencias y brindar ayuda inicial puede salvar vidas.',
            fuente: 'Manual de Primeros Auxilios, Cruz Roja Americana (pág. 13)',
            archivo: 'assets/FA-CPR-AED-Spanish-Manual.pdf',
            pagina: 13
        }
    },
    'hemorragia': {
        titulo: 'Control de Hemorragias',
        descripcion: 'Cómo detener el sangrado excesivo aplicando presión directa y elevando la herida.',
        icono: 'https://img.icons8.com/color/96/blood-drop.png',
        imagen: 'assets/control-hemorragias.png',
        badge: 'URGENTE',
        tiempo: '1-2 min',
        dificultad: 'Fácil',
        precauciones: {
            titulo: 'Precauciones',
            categoria: 'Medidas importantes',
            descripcion: 'Las hemorragias pueden ser causadas por diversos tipos de lesiones, desde cortes menores hasta heridas graves. Es fundamental actuar rápidamente para controlar el sangrado y prevenir la pérdida excesiva de sangre.\n\nUna hemorragia severa puede causar shock hipovolémico en cuestión de minutos, lo que puede ser fatal si no se trata inmediatamente. El tiempo es crucial en estas situaciones.',
            pasos: [
                'Evaluar la gravedad de la hemorragia',
                'Aplicar presión directa sobre la herida',
                'Elevar la extremidad afectada si es posible',
                'Buscar atención médica inmediata'
            ],
            resumen: 'El control rápido de hemorragias puede salvar vidas. La presión directa y la elevación son técnicas fundamentales que todos deben conocer.',
            fuente: 'Manual de Primeros Auxilios, Cruz Roja Americana (pág. 25)',
            archivo: 'assets/FA-CPR-AED-Spanish-Manual.pdf',
            pagina: 25
        }
    }
};

// Variables globales
let currentEmergency = null;
let isFavorite = false;

// Función para obtener parámetros de la URL
function getUrlParameter(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Función para cargar datos de la emergencia
function loadEmergencyData() {
    const emergencyId = getUrlParameter('id');
    
    if (!emergencyId || !emergencyData[emergencyId]) {
        // Si no hay ID válido, redirigir al menú
        window.location.href = 'menu.html';
        return;
    }
    
    currentEmergency = emergencyData[emergencyId];
    
    // Cargar datos del usuario
    loadUserData();
    
    // Actualizar la página con los datos
    updatePageContent();
    
    // Verificar si está en favoritos
    checkFavoriteStatus(emergencyId);
}

// Función para actualizar el contenido de la página
function updatePageContent() {
    if (!currentEmergency) return;
    
    // Actualizar header
    document.getElementById('emergency-icon').src = currentEmergency.icono;
    document.getElementById('emergency-badge').textContent = currentEmergency.badge;
    document.getElementById('emergency-title').textContent = currentEmergency.titulo;
    document.getElementById('emergency-description').textContent = currentEmergency.descripcion;
    
    // Actualizar imagen
    document.getElementById('emergency-image').src = currentEmergency.imagen;
    
    // Actualizar precauciones
    document.getElementById('precautions-description').textContent = currentEmergency.precauciones.descripcion;
    
    // Actualizar pasos
    const stepsList = document.getElementById('precautions-steps');
    stepsList.innerHTML = '';
    currentEmergency.precauciones.pasos.forEach(paso => {
        const li = document.createElement('li');
        li.textContent = paso;
        stepsList.appendChild(li);
    });
    
    // Actualizar resumen
    document.getElementById('precautions-summary').textContent = currentEmergency.precauciones.resumen;
    
    // Actualizar información de fuente
    document.getElementById('source-text').textContent = currentEmergency.precauciones.fuente;
    document.getElementById('page-number').textContent = currentEmergency.precauciones.pagina;
    document.getElementById('file-link').href = currentEmergency.precauciones.archivo;
    
    // Actualizar estadísticas rápidas
    document.getElementById('time-estimate').textContent = currentEmergency.tiempo;
    document.getElementById('difficulty').textContent = currentEmergency.dificultad;
}

// Función para cargar datos del usuario
function loadUserData() {
    const userData = JSON.parse(localStorage.getItem('userData')) || {};
    const usernameElement = document.querySelector('.username');
    
    if (usernameElement && userData.nombre) {
        usernameElement.textContent = userData.nombre;
    }
}

// Función para verificar si está en favoritos
function checkFavoriteStatus(emergencyId) {
    const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    isFavorite = favorites.includes(emergencyId);
    updateFavoriteButton();
}

// Función para actualizar el botón de favorito
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

// Función para alternar favorito
function toggleFavorite() {
    if (!currentEmergency) return;
    
    const emergencyId = getUrlParameter('id');
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    
    if (isFavorite) {
        // Remover de favoritos
        favorites = favorites.filter(id => id !== emergencyId);
        showNotification('Removido de favoritos', 'success');
    } else {
        // Agregar a favoritos
        favorites.push(emergencyId);
        showNotification('Agregado a favoritos', 'success');
    }
    
    localStorage.setItem('favorites', JSON.stringify(favorites));
    isFavorite = !isFavorite;
    updateFavoriteButton();
}

// Función para descargar emergencia
function downloadEmergency() {
    if (!currentEmergency) return;
    
    // Simular descarga
    showNotification('Descargando información...', 'info');
    
    // Aquí se podría implementar la descarga real del archivo
    setTimeout(() => {
        showNotification('Descarga completada', 'success');
    }, 2000);
}

// Función para compartir emergencia
function shareEmergency() {
    if (!currentEmergency) return;
    
    // Verificar si el navegador soporta la API de compartir
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
        // Fallback: copiar URL al portapapeles
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification('URL copiada al portapapeles', 'success');
        }).catch(() => {
            showNotification('Error al copiar URL', 'error');
        });
    }
}

// Función para volver al menú
function goBack() {
    window.location.href = 'menu.html';
}

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

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    loadEmergencyData();
    
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
    
    // Agregar efecto de carga
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
}); 