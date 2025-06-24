// Función para alternar favoritos
function toggleFavorite(button) {
    try {
        // Cambiar el estado visual del botón
        if (button.classList.contains('favorited')) {
            // Si ya está en favoritos, lo removemos
            button.classList.remove('favorited');
            button.innerHTML = '<span>🤍</span> Agregar a favoritos';
            
            // Simular notificación
            alert('Eliminado de favoritos ✨');
        } else {
            // Si no está en favoritos, lo agregamos
            button.classList.add('favorited');
            button.innerHTML = '<span>❤️</span> Quitar de favoritos';
            
            // Simular notificación
            alert('Agregado a favoritos ❤️');
        }
    } catch (error) {
        console.error('Error al manejar favorito:', error);
    }
}

// Agregar estilos dinámicamente
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .favorite-btn {
            transition: all 0.3s ease;
            cursor: pointer;
            color: #666;
        }
        
        .favorite-btn.favorited {
            color: #ff0000;
        }
        
        .favorite-btn:hover {
            transform: scale(1.1);
        }
        
        .favorite-btn span {
            margin-right: 5px;
        }
    </style>
`);

// Inicializar favoritos
document.addEventListener('DOMContentLoaded', function() {
    // Agregar manejadores de eventos a los botones de favorito
    const buttons = document.querySelectorAll('.favorite-btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Evitar que el clic se propague al contenedor
            toggleFavorite(this);
        });
    });
});
