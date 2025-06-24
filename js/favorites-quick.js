// Función simple para alternar favoritos
function toggleFavorite(button) {
    // Cambiar el estado visual
    if (button.classList.contains('favorited')) {
        // Si ya está en favoritos, lo removemos
        button.classList.remove('favorited');
        button.querySelector('span').textContent = '🤍';
        button.innerHTML = button.innerHTML.replace('❤️', '🤍');
        button.innerHTML = button.innerHTML.replace('Quitar de favoritos', 'Agregar a favoritos');
        
        // Simular notificación
        alert('Eliminado de favoritos ✨');
    } else {
        // Si no está en favoritos, lo agregamos
        button.classList.add('favorited');
        button.querySelector('span').textContent = '❤️';
        button.innerHTML = button.innerHTML.replace('🤍', '❤️');
        button.innerHTML = button.innerHTML.replace('Agregar a favoritos', 'Quitar de favoritos');
        
        // Simular notificación
        alert('Agregado a favoritos ❤️');
    }
}

// Agregar estilos dinámicamente
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .favorite-btn {
            transition: all 0.3s ease;
        }
        
        .favorite-btn.favorited {
            color: #ff0000;
        }
        
        .favorite-btn:hover {
            transform: scale(1.1);
        }
    </style>
`);
