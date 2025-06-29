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
        localStorage.removeItem("casoSeleccionado");
    }

    if (!emergencyId || !emergencyData[emergencyId]) {
        window.location.href = 'menu.php';
        return;
    }

    currentEmergency = emergencyData[emergencyId];

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
    document.getElementById('precautions-description').textContent = currentEmergency.nota;

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
    console.log('Datos de emergencia:', currentEmergency); // Depuración
    
    if (!currentEmergency) {
        showNotification('No se puede descargar la emergencia', 'error');
        return;
    }

    // Verificar que los datos necesarios existen
    if (!currentEmergency.titulo || !currentEmergency.descripcion || !currentEmergency.pasos || !currentEmergency.resumen) {
        console.error('Faltan datos necesarios para generar el PDF');
        showNotification('No se pueden generar los datos del PDF', 'error');
        return;
    }

    // Crear un nuevo PDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'pt', 'a4');
    
    // Configuración de márgenes y dimensiones
    const margin = 40;
    let y = margin;

    // Agregar logo de Asclepio en la esquina superior izquierda
    const logoUrl = 'img/serpiente 2.png';
    doc.addImage(logoUrl, 'PNG', margin, margin, 50, 50);
    y += 80; // Aumentar el espacio vertical
    doc.setFontSize(24);
    doc.setFont('helvetica', 'bold');
    doc.text(currentEmergency.titulo, margin + 40, y); // Mover el texto más a la izquierda
    y += 40;

    // Agregar descripción
    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');
    const descLines = doc.splitTextToSize(currentEmergency.descripcion, 500);
    descLines.forEach(line => {
        doc.text(line, margin + 40, y); // Mover el texto más a la izquierda
        y += 15;
    });
    y += 20;

    // Agregar pasos
    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('Pasos a seguir:', margin + 40, y); // Mover el texto más a la izquierda
    y += 20;

    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');
    currentEmergency.pasos.forEach((paso, index) => {
        doc.text(`${index + 1}. ${paso}`, margin + 40, y); // Mover el texto más a la izquierda
        y += 15;
    });
    y += 20;

    // Agregar resumen
    doc.setFontSize(14);
    doc.setFont('helvetica', 'bold');
    doc.text('Resumen:', margin + 40, y); // Mover el texto más a la izquierda
    y += 20;

    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');
    const summaryLines = doc.splitTextToSize(currentEmergency.resumen, 500);
    summaryLines.forEach(line => {
        doc.text(line, margin + 40, y); // Mover el texto más a la izquierda
        y += 15;
    });

    // Guardar el PDF
    const fileName = `${currentEmergency.titulo.replace(/[^a-zA-Z0-9]/g, '_')}.pdf`;
    doc.save(fileName);

    showNotification('PDF generado y descargado', 'success');
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
    window.location.href = 'menu.php';
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
        usernameElement.addEventListener('click', () => window.location.href = 'perfil.php');
    }

    const logoTitle = document.querySelector('.logo-title');
    if (logoTitle) {
        logoTitle.addEventListener('dblclick', () => {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                localStorage.clear();
                window.location.href = 'login.php';
            }
        });
    }

    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});