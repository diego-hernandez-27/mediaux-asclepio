<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asclepio - Perfil de Usuario</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="img/logo.png" alt="Logo Asclepio" class="logo">
            <h1>ASCLEPIO</h1>
        </div>
        <div class="back-button">
            <a href="menu.php" class="btn-back">← Volver al Menú</a>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="https://i.imgur.com/4ZQeZsK.png" alt="Avatar" class="avatar">
                    <div class="avatar-overlay">
                        <span>📷</span>
                    </div>
                </div>
                <div class="profile-info">
                    <h2 id="user-name">Usuario</h2>
                    <p id="user-email">usuario@email.com</p>
                    <span class="status-badge">Activo</span>
                </div>
            </div>

            <div class="profile-sections">
                <!-- Información Personal -->
                <div class="section">
                    <h3>📋 Información Personal</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nombre completo:</label>
                            <span id="full-name">Usuario Ejemplo</span>
                        </div>
                        <div class="info-item">
                            <label>Fecha de nacimiento:</label>
                            <span id="birth-date">01/01/1990</span>
                        </div>
                        <div class="info-item">
                            <label>Teléfono:</label>
                            <span id="phone">+52 55 1234 5678</span>
                        </div>
                        <div class="info-item">
                            <label>Género:</label>
                            <span id="gender">No especificado</span>
                        </div>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="section">
                    <h3>📍 Dirección</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Calle:</label>
                            <span id="street">Calle Ejemplo</span>
                        </div>
                        <div class="info-item">
                            <label>Número:</label>
                            <span id="number">123</span>
                        </div>
                        <div class="info-item">
                            <label>Colonia:</label>
                            <span id="colony">Colonia Ejemplo</span>
                        </div>
                        <div class="info-item">
                            <label>Ciudad:</label>
                            <span id="city">Ciudad de México</span>
                        </div>
                        <div class="info-item">
                            <label>Estado:</label>
                            <span id="state">CDMX</span>
                        </div>
                        <div class="info-item">
                            <label>Código Postal:</label>
                            <span id="zip">12345</span>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="section">
                    <h3>📊 Estadísticas</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">12</div>
                            <div class="stat-label">Citas realizadas</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">5</div>
                            <div class="stat-label">Hospitales visitados</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">8</div>
                            <div class="stat-label">Doctores consultados</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">3</div>
                            <div class="stat-label">Especialidades</div>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="section">
                    <h3>⚙️ Acciones</h3>
                    <div class="actions-grid">
                        <button class="action-btn edit-btn">
                            <span>✏️</span>
                            Editar Perfil
                        </button>
                        <button class="action-btn password-btn">
                            <span>🔒</span>
                            Cambiar Contraseña
                        </button>
                        <button class="action-btn preferences-btn">
                            <span>⚙️</span>
                            Preferencias
                        </button>
                        <button class="action-btn logout-btn" onclick="logout()">
                            <span>🚪</span>
                            Cerrar Sesión
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/perfil.js"></script>
</body>
</html> 