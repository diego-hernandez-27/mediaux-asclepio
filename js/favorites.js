document.addEventListener('DOMContentLoaded', function() {
    // Agregar manejadores de eventos a los botones de favorito
    const favoriteButtons = document.querySelectorAll('.favorite-button');
    favoriteButtons.forEach(button => {
        button.addEventListener('click', handleFavoriteClick);
    });
});

async function handleFavoriteClick(event) {
    const button = event.target;
    const id = button.dataset.id;
    const isFavorite = button.classList.contains('favorited');

    try {
        if (isFavorite) {
            // Eliminar favorito
            await removeFavorite(id);
            toggleFavorite(button);
        } else {
            // Agregar favorito
            await addFavorite(id);
            toggleFavorite(button);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar el favorito');
    }
}

// Función para alternar favoritos
function toggleFavorite(button) {
    // Cambiar el estado visual del botón
    if (button.classList.contains('favorited')) {
        // Si ya está en favoritos, lo removemos
        button.classList.remove('favorited');
        button.innerHTML = '<i class="fas fa-heart"></i> Agregar a favoritos';
        alert('Eliminado de favoritos ');
    } else {
        // Si no está en favoritos, lo agregamos
        button.classList.add('favorited');
        button.innerHTML = '<i class="fas fa-heart"></i> Eliminar de favoritos';
        alert('Agregado a favoritos ');
    }
}

async function addFavorite(id) {
    const response = await fetch('api/favorites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: id })
    });
    const data = await response.json();
    if (!data.success) {
        throw new Error(data.message);
    }
}

async function removeFavorite(id) {
    const response = await fetch(`api/favorites.php?id=${id}`, {
        method: 'DELETE'
    });
    const data = await response.json();
    if (!data.success) {
        throw new Error(data.message);
    }
}
