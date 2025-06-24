// Función para manejar favoritos
function toggleFavorite(itemId) {
    try {
        // Obtener el botón de favorito
        const button = document.querySelector(`.favorite-btn[data-id="${itemId}"]`);
        if (!button) return;

        // Obtener el ícono de favorito
        const icon = button.querySelector('span');
        if (!icon) return;

        // Simular animación
        button.classList.add('animating');
        
        // Cambiar el estado visual
        if (button.classList.contains('favorited')) {
            // Si ya está en favoritos, lo removemos
            button.classList.remove('favorited');
            icon.textContent = '🤍';
            
            // Remover de la sección de favoritos
            const favoritesGrid = document.getElementById('favorites-grid');
            const favoriteCard = favoritesGrid.querySelector(`[data-id="${itemId}"]`);
            if (favoriteCard) {
                favoriteCard.remove();
            }
            
            // Simular notificación
            showNotification('Eliminado de favoritos', 'success');
        } else {
            // Si no está en favoritos, lo agregamos
            button.classList.add('favorited');
            icon.textContent = '❤️';
            
            // Agregar a la sección de favoritos
            const favoritesGrid = document.getElementById('favorites-grid');
            if (favoritesGrid) {
                // Crear tarjeta de favorito
                const originalCard = button.closest('.emergency-card');
                if (originalCard) {
                    const favoriteCard = originalCard.cloneNode(true);
                    favoriteCard.dataset.id = itemId;
                    favoriteCard.querySelector('.favorite-btn').innerHTML = `
                        <span>❤️</span>
                        Quitar de favoritos
                    `;
                    
                    // Ajustar estilos
                    favoriteCard.style.cursor = 'pointer';
                    
                    // Agregar al inicio de la lista de favoritos
                    favoritesGrid.insertBefore(favoriteCard, favoritesGrid.firstChild);
                }
            }
            
            // Simular notificación
            showNotification('Agregado a favoritos', 'success');
        }
        
        // Simular animación de finalización
        setTimeout(() => {
            button.classList.remove('animating');
        }, 500);
    } catch (error) {
        console.error('Error al manejar favorito:', error);
        showNotification('Error al procesar favorito', 'error');
    }
}

// Función para mostrar notificaciones
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    // Agregar animación
    notification.style.opacity = '0';
    notification.style.transform = 'translateY(20px)';
    
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    }, 100);
    
    // Eliminar después de 3 segundos
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(20px)';
        
        // Eliminar después de la animación
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Agregar estilos dinámicamente
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .favorite-button {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .favorite-button.favorited {
            color: #ff0000;
        }
        
        .favorite-button.animating {
            transform: scale(1.2);
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 5px;
            color: white;
            background: #4CAF50;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .notification.error {
            background: #f44336;
        }
        
        .notification.success {
            background: #4CAF50;
        }
    </style>
`);

// Inicializar favoritos
document.addEventListener('DOMContentLoaded', function() {
    // Agregar manejadores de eventos a los botones de favorito
    const buttons = document.querySelectorAll('.favorite-button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            toggleFavorite(this);
        });
    });
});
