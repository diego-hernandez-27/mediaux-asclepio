// Simular favoritos usando localStorage
function toggleFavorite(button) {
    const id = button.dataset.id;
    const isFavorite = button.classList.contains('favorited');
    
    // Simular animación de cambio
    button.classList.add('animating');
    setTimeout(() => {
        button.classList.remove('animating');
        
        // Cambiar el estado visual
        if (isFavorite) {
            button.classList.remove('favorited');
            button.innerHTML = '<i class="fas fa-heart"></i> Agregar a favoritos';
            // Simular sonido de eliminación
            new Audio('https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3').play();
        } else {
            button.classList.add('favorited');
            button.innerHTML = '<i class="fas fa-heart"></i> Eliminado de favoritos';
            // Simular sonido de adición
            new Audio('https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3').play();
        }
    }, 500);
}

// Agregar estilos dinámicos
document.head.insertAdjacentHTML('beforeend', `
    <style>
        .favorite-button {
            transition: all 0.3s ease;
        }
        .favorite-button.animating {
            transform: scale(1.2);
        }
        .favorite-button.favorited {
            color: red;
        }
        .favorite-button.favorited i {
            animation: heartPulse 1s infinite;
        }
        @keyframes heartPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
`);

// Inicializar favoritos
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.favorite-button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            toggleFavorite(this);
        });
    });
});
