<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asclepio - Detalle de Emergencia</title>
    <link rel="stylesheet" href="css/emergency-detail.css">
    <link rel="stylesheet" href="css/logos.css">
    <!-- Incluir biblioteca jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <h1>ASCLEPIO</h1>
            <div class="logo-container">
                <img src="img/serpiente 2.png" alt="Logo Asclepio" class="logo">
                <img src="img/mediaux.png" alt="Logo Mediaux" class="logo mediaux-logo">
            </div>
        </div>
        <div class="user-profile">
            <span class="username"><?= htmlspecialchars($_SESSION['usuario']) ?></span>
            <img src="./img/perfil/perfil.jpeg" alt="Profile" class="profile-pic">
        </div>
    </div>

    <div class="back-button">
        <button onclick="goBack()" class="back-btn">
            <span>←</span> Volver al Menú
        </button>
    </div>

    <div class="emergency-detail-container">
        <div class="emergency-header">
            <div class="emergency-icon">
                <img id="emergency-icon" src="" alt="Icono de Emergencia">
                <div class="emergency-badge" id="emergency-badge">CRÍTICO</div>
            </div>
            <div class="emergency-title">
                <h1 id="emergency-title">Título de la Emergencia</h1>
                <p id="emergency-description">Descripción breve de la emergencia</p>
            </div>
        </div>

        <div class="content-grid">
            <div class="main-content">
                <div class="section precautions-section">
                    <h2>🚨 Precauciones</h2>
                    <div class="category-badge">Medidas importantes</div>
                    <p id="precautions-description" class="description-text">
                        Las emergencias médicas pueden ocurrir todos los días y en cualquier entorno. Las personas pueden lesionarse en situaciones como caídas o accidentes de vehículos a motor, o desarrollar enfermedades repentinas como ataques al corazón o derrames cerebrales.
                    </p>
                    
                    <div class="steps-container">
                        <h3>Pasos a seguir:</h3>
                        <ol id="precautions-steps" class="steps-list">
                            <li>Advertir que hay una emergencia</li>
                            <li>Decidir actuar</li>
                            <li>Activar el sistema de servicios médicos de emergencia</li>
                            <li>Atender hasta que llegue la ayuda</li>
                        </ol>
                    </div>

                    <div class="summary-box">
                        <h4>📋 Resumen</h4>
                        <p id="precautions-summary">
                            Las emergencias médicas ocurren de forma inesperada. Estar preparado para reconocerlas, actuar con decisión, activar el sistema de emergencias y brindar ayuda inicial puede salvar vidas.
                        </p>
                    </div>
                </div>

                <div class="section source-section">
                    <h2>📚 Información de Fuente</h2>
                    <div class="source-info">
                        <p><strong>Fuente:</strong> <span id="source-text">Manual de Primeros Auxilios, Cruz Roja Americana (pág. 13)</span></p>
                        <p><strong>Página:</strong> <span id="page-number">13</span></p>
                        <div class="file-download">
                            <a href="#" id="file-link" class="download-link" download>
                                <span>📄</span> Descargar Manual Completo
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar">
                <div class="emergency-image">
                    <img id="emergency-image" src="" alt="Imagen de Emergencia">
                </div>
                
                <div class="action-buttons">
                    <button class="action-btn download-btn" onclick="downloadEmergency()">
                        <span>⬇️</span> Descargar
                    </button>
                    <button class="action-btn favorite-btn" onclick="toggleFavorite()">
                        <span id="favorite-icon">🤍</span> Favorito
                    </button>
                </div>

                <div class="quick-stats">
                    <div class="stat-item">
                        <span class="stat-icon">⏱️</span>
                        <span class="stat-label">Tiempo estimado:</span>
                        <span class="stat-value" id="time-estimate">2-3 min</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon">📱</span>
                        <span class="stat-label">Dificultad:</span>
                        <span class="stat-value" id="difficulty">Fácil</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="corner-logo">
        <img src="img/serpiente 2.png" alt="Asclepio Logo">
    </div>

    <script src="js/emergency-detail.js"></script>
</body>
</html> 