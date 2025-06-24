// Función para sincronizar el estado de favorito
function syncFavoriteState(button, isFavorited) {
    const id = button.dataset.id;
    
    // Actualizar el botón original
    const originalButtons = document.querySelectorAll(`.favorite-btn[data-id="${id}"]`);
    originalButtons.forEach(btn => {
        btn.classList.toggle('favorited', isFavorited);
        btn.innerHTML = isFavorited ? '<span>❤️</span> Quitar de favoritos' : '<span>🤍</span> Agregar a favoritos';
    });
    
    // Actualizar la tarjeta en favoritos
    const favoritesGrid = document.getElementById('favorites-grid');
    if (favoritesGrid) {
        const favoriteCard = favoritesGrid.querySelector(`[data-id="${id}"]`);
        if (favoriteCard) {
            const favoriteButton = favoriteCard.querySelector('.favorite-btn');
            if (favoriteButton) {
                favoriteButton.classList.toggle('favorited', isFavorited);
                favoriteButton.innerHTML = isFavorited ? '<span>❤️</span> Quitar de favoritos' : '<span>🤍</span> Agregar a favoritos';
            }
        }
    }
}

// Función para crear una tarjeta simulada de favorito
function createFavoriteCard(button) {
    const originalCard = button.closest('.emergency-card');
    if (!originalCard) return null;
    
    // Crear una nueva tarjeta basada en la original
    const card = document.createElement('div');
    card.className = 'emergency-card';
    card.style.cursor = 'pointer';
    card.dataset.id = button.dataset.id; // Agregar el ID para identificar la tarjeta
    
    // Copiar el contenido relevante
    const title = originalCard.querySelector('h3').textContent;
    const description = originalCard.querySelector('.description').textContent;
    
    // Crear el HTML de la tarjeta
    card.innerHTML = `
        <div class="card-image">
            <img src="${originalCard.querySelector('img').src}" alt="${title}">
            <div class="emergency-badge">FAVORITO</div>
        </div>
        <div class="card-content">
            <h3>${title}</h3>
            <p class="description">${description}</p>
            <div class="card-stats">
                <span class="stat">❤️ Favorito</span>
            </div>
        </div>
        <div class="card-actions">
            <div class="action-buttons">
                <button class="action-btn download-btn" onclick="downloadEmergency('${button.dataset.id}')">
                    <span>⬇️</span>
                    Descargar
                </button>
                <button class="action-btn favorite-btn">
                    <span>❤️</span>
                    Quitar de favoritos
                </button>
            </div>
        </div>
    `;
    
    // Agregar el evento clic al botón de quitar
    const favoriteButton = card.querySelector('.favorite-btn');
    if (favoriteButton) {
        favoriteButton.onclick = null; // Remover cualquier evento existente
        favoriteButton.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleFavorite(this);
        });
    }
    
    return card;
}

// Función simple para alternar favoritos
function toggleFavorite(button) {
    const isFavorited = !button.classList.contains('favorited');
    
    // Actualizar el estado visual del botón
    if (isFavorited) {
        // Si no está en favoritos, lo agregamos
        button.classList.add('favorited');
        button.innerHTML = '<span>❤️</span> Quitar de favoritos';
        
        // Agregar la tarjeta a favoritos
        const favoritesGrid = document.getElementById('favorites-grid');
        if (favoritesGrid) {
            const card = createFavoriteCard(button);
            if (card) {
                favoritesGrid.insertBefore(card, favoritesGrid.firstChild);
            }
        }
        
        alert('Agregado a favoritos ❤️');
    } else {
        // Si ya está en favoritos, lo removemos
        button.classList.remove('favorited');
        button.innerHTML = '<span>🤍</span> Agregar a favoritos';
        
        // Remover la tarjeta de favoritos si existe
        const favoritesGrid = document.getElementById('favorites-grid');
        if (favoritesGrid) {
            // Remover todas las tarjetas con este ID
            const favoriteCards = favoritesGrid.querySelectorAll(`[data-id="${button.dataset.id}"]`);
            favoriteCards.forEach(card => card.remove());
        }
        
        alert('Eliminado de favoritos ✨');
    }
    
    // Sincronizar el estado en todos los botones
    syncFavoriteState(button, isFavorited);
}

// Inicializar favoritos
document.addEventListener('DOMContentLoaded', function() {
    // Agregar manejadores de eventos a los botones de favorito
    const buttons = document.querySelectorAll('.favorite-btn');
    buttons.forEach(button => {
        // Remover cualquier evento onclick existente
        button.onclick = null;
        
        // Agregar el nuevo evento
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleFavorite(this);
        });
    });
});
