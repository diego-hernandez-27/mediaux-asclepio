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
    <title>Asclepio - Menú Principal</title>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/emergencia.css">
</head>
<body>
    <div class="header">
        <div class="logo-title">
            <img src="img/logo.png" alt="Logo Asclepio" class="logo">
            <h1>ASCLEPIO</h1>
        </div>
        <div class="user-profile">
            <span class="username"><?= htmlspecialchars($_SESSION['usuario']) ?></span>
            <img src="https://i.imgur.com/4ZQeZsK.png" alt="Profile" class="profile-pic">
        </div>
    </div>

    <div class="search-bar">
        <input type="text" placeholder="">
        <button class="search-btn">🔍</button>
    </div>

    <div class="menu-icons">
        <div class="icon" onclick="showEmergencySection()">
            <img src="img/icons/emergency.png" alt="Emergencia"/>
            <p>Emergencia</p>
        </div>
        <div class="icon" onclick="showHistorialSection()">
            <img src="img/icons/clock.png" alt="Historial"/>
            <p>Historial</p>
        </div>
        <div class="icon" onclick="showMapSection()">
            <img src="img/icons/mapa.png" alt="Mapa"/>
            <p>Mapa</p>
        </div>
        <div class="icon" onclick="showFavoritosSection()">
            <img src="img/icons/favoritos.png" alt="Favoritos"/>
            <p>Favoritos</p>
        </div>
    </div>

    <!-- Sección de Emergencias (visible por defecto) -->
    <div id="emergency-section" class="emergency-section">
        <div class="emergency-container">
            <div class="page-title">
                <h2>🚨 Emergencias Médicas</h2>
                <p>Información rápida para situaciones de emergencia</p>
            </div>

            <div class="emergency-grid">
                <!-- Tarjeta 1: Precauciones -->
                <div class="emergency-card" onclick="openEmergencyDetail('precauciones')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/caution.png" alt="Precauciones">
                        <div class="emergency-badge">CRÍTICO</div>
                    </div>
                    <div class="card-content">
                        <h3>Precauciones antes de realizar primeros auxilios</h3>
                        <p class="description">Las emergencias médicas ocurren de forma inesperada. Estar preparado para reconocerlas, actuar con decisión, activar el sistema de emergencias y brindar ayuda inicial puede salvar vidas.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 2-3 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('precauciones')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('precauciones')">
                                <span id="favorite-rcp">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('precauciones')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-rcp">
                                <div class="dropdown-item" onclick="shareEmergency('precauciones')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('precauciones')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 2: Atragantamiento -->
                <div class="emergency-card" onclick="openEmergencyDetail('atragantamiento')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/choking.png" alt="atragantamiento">
                        <div class="emergency-badge">CRÍTICO</div>
                    </div>
                    <div class="card-content">
                        <h3>Atragantamiento</h3>
                        <p class="description">El atragantamiento puede causar una emergencia respiratoria grave. Actuar rápido puede salvar una vida.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 2-3 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('atragantamiento')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('atragantamiento')">
                                <span id="favorite-rcp">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('atragantamiento')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-rcp">
                                <div class="dropdown-item" onclick="shareEmergency('atragantamiento')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('atragantamiento')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 3: RCP -->
                <div class="emergency-card" onclick="openEmergencyDetail('rcp_adulto')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/heart-with-pulse.png" alt="RCP">
                        <div class="emergency-badge">CRÍTICO</div>
                    </div>
                    <div class="card-content">
                        <h3>Reanimación Cardiopulmonar (RCP)</h3>
                        <p class="description">Técnica de emergencia para salvar vidas cuando alguien ha dejado de respirar o su corazón ha dejado de latir.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 2-3 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('rcp')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('rcp')">
                                <span id="favorite-rcp">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('rcp')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-rcp">
                                <div class="dropdown-item" onclick="shareEmergency('rcp')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('rcp')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 4: Asfixia -->
                <div class="emergency-card" onclick="openEmergencyDetail('asfixia')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/difficulty-breathing.png" alt="Asfixia">
                        <div class="emergency-badge">CRÍTICO</div>
                    </div>
                    <div class="card-content">
                        <h3>Obstrucción de vías respiratorias (Asfixia)</h3>
                        <p class="description">La obstrucción de las vías respiratorias ocurre cuando un objeto bloquea el paso del aire, lo que puede causar asfixia. Puede ser parcial o total, y requiere atención inmediata.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 1-2 min</span>
                            <span class="stat">📱 Difícil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('asfixia')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('asfixia')">
                                <span id="favorite-ahogamiento">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('asfixia')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-ahogamiento">
                                <div class="dropdown-item" onclick="shareEmergency('asfixia')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('asfixia')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 5: Ataque Cardíaco -->
                <div class="emergency-card" onclick="openEmergencyDetail('ataque_cardiaco')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/heart-attack.png" alt="Ataque Cardíaco">
                        <div class="emergency-badge">CRÍTICO</div>
                    </div>
                    <div class="card-content">
                        <h3>Síntomas de Ataque Cardíaco</h3>
                        <p class="description">Identificación de síntomas y primeros auxilios para ataques cardíacos.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 1 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('ataque-cardiaco')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('ataque-cardiaco')">
                                <span id="favorite-ataque-cardiaco">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('ataque-cardiaco')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-ataque-cardiaco">
                                <div class="dropdown-item" onclick="shareEmergency('ataque-cardiaco')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('ataque-cardiaco')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 6: DEA (Desfibilador Externo Automatico) -->
                <div class="emergency-card" onclick="openEmergencyDetail('dea')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/defibrillator.png" alt="DEA">
                        <div class="emergency-badge">CRÍTICO</div>
                    </div>
                    <div class="card-content">
                        <h3>Uso del DEA</h3>
                        <p class="description">El DEA puede salvar vidas restableciendo el ritmo cardíaco tras un paro. Debe usarse lo antes posible junto con RCP.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 1 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('dea')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('dea')">
                                <span id="favorite-ataque-cardiaco">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('dea')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-ataque-cardiaco">
                                <div class="dropdown-item" onclick="shareEmergency('dea')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('dea')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 7: Hemorragia -->
                <div class="emergency-card" onclick="openEmergencyDetail('hemorragias')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/blood-drop.png" alt="Hemorragia">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Control de Hemorragias</h3>
                        <p class="description">Cómo detener el sangrado excesivo aplicando presión directa y elevando la herida.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 1-2 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('hemorragia')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('hemorragia')">
                                <span id="favorite-hemorragia">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('hemorragia')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-hemorragia">
                                <div class="dropdown-item" onclick="shareEmergency('hemorragia')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('hemorragia')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 8: Derrame Cerebral -->
                <div class="emergency-card" onclick="openEmergencyDetail('derrame_cerebral')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/stroke.png" alt="Derrame Cerebral">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Derrame Cerebral</h3>
                        <p class="description">Un derrame cerebral ocurre cuando se interrumpe el flujo sanguíneo hacia el cerebro, ya sea por bloqueo o ruptura de un vaso. Puede causar parálisis, pérdida del habla, visión borrosa o confusión.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 1-2 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('derrame_cerebral')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('derrame_cerebral')">
                                <span id="favorite-hemorragia">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('derrame_cerebral')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-hemorragia">
                                <div class="dropdown-item" onclick="shareEmergency('derrame_cerebral')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('derrame_cerebral')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 9: Convulsiones -->
                <div class="emergency-card" onclick="openEmergencyDetail('convulsiones')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/seizure.png" alt="Convulsiones">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Convulsiones</h3>
                        <p class="description">Las convulsiones suelen durar pocos minutos. Mantenga la seguridad y permita que la persona se recupere tranquila.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 3-5 min</span>
                            <span class="stat">📱 Medio</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('convulsiones')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('convulsiones')">
                                <span id="favorite-quemaduras">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('convulsiones')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-quemaduras">
                                <div class="dropdown-item" onclick="shareEmergency('convulsiones')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('convulsiones')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 9: Shock -->
                <div class="emergency-card" onclick="openEmergencyDetail('shock')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/abandoned.png" alt="Shock">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Estado de Shock</h3>
                        <p class="description">El shock es una falla circulatoria crítica. Debe tratarse con rapidez para prevenir daño a órganos vitales.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 3-5 min</span>
                            <span class="stat">📱 Medio</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('shock')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('shock')">
                                <span id="favorite-quemaduras">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('shock')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-quemaduras">
                                <div class="dropdown-item" onclick="shareEmergency('shock')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('shock')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 10: Fracturas -->
                <div class="emergency-card" onclick="openEmergencyDetail('fractura')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/broken-bone.png" alt="Fracturas">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Inmovilización de Fracturas</h3>
                        <p class="description">Cómo inmovilizar fracturas y esguinces antes de llegar al hospital.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 5-10 min</span>
                            <span class="stat">📱 Medio</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('fracturas')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('fracturas')">
                                <span id="favorite-fracturas">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('fracturas')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-fracturas">
                                <div class="dropdown-item" onclick="shareEmergency('fracturas')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('fracturas')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 11: Quemaduras -->
                <div class="emergency-card" onclick="openEmergencyDetail('quemaduras')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/burn.png" alt="Quemaduras">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Primeros Auxilios en Quemaduras</h3>
                        <p class="description">Tratamiento inmediato para quemaduras de primer, segundo y tercer grado.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 3-5 min</span>
                            <span class="stat">📱 Medio</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('quemaduras')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('quemaduras')">
                                <span id="favorite-quemaduras">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('quemaduras')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-quemaduras">
                                <div class="dropdown-item" onclick="shareEmergency('quemaduras')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('quemaduras')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 12: Intoxicaciones -->
                <div class="emergency-card" onclick="openEmergencyDetail('intoxicaciones')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/virus.png" alt="intoxicaciones">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Intoxicaciones</h3>
                        <p class="description">Las intoxicaciones deben tratarse rápido. Llame al centro de envenenamiento y proporcione datos sobre la sustancia para recibir orientación adecuada.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 3-5 min</span>
                            <span class="stat">📱 Medio</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('intoxicaciones')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('intoxicaciones')">
                                <span id="favorite-quemaduras">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('intoxicaciones')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-quemaduras">
                                <div class="dropdown-item" onclick="shareEmergency('intoxicaciones')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('intoxicaciones')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 12: Alergias -->
                <div class="emergency-card" onclick="openEmergencyDetail('alergias_graves')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/antihistamines.png" alt="alergias_graves'">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Alergias Graves</h3>
                        <p class="description">La anafilaxia es una reacción alérgica grave que puede causar dificultad para respirar, hinchazón y shock. Puede ser desencadenada por alimentos, medicamentos o picaduras. Es potencialmente mortal si no se trata de inmediato.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 3-5 min</span>
                            <span class="stat">📱 Medio</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('alergias_graves')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('alergias_graves')">
                                <span id="favorite-quemaduras">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('alergias_graves')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-quemaduras">
                                <div class="dropdown-item" onclick="shareEmergency('alergias_graves')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('alergias_graves')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 12: Heimlich -->
                <div class="emergency-card" onclick="openEmergencyDetail('heimlich')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/heimlich.png" alt="heimlich'">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Uso de la Maniobra de Heimlich</h3>
                        <p class="description">La maniobra de Heimlich se utiliza cuando una persona adulta consciente se atraganta y no puede hablar, toser o respirar. Consiste en una serie de compresiones abdominales para expulsar el objeto que obstruye la vía aérea.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 3-5 min</span>
                            <span class="stat">📱 Medio</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('heimlich')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('heimlich')">
                                <span id="favorite-quemaduras">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('heimlich')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-quemaduras">
                                <div class="dropdown-item" onclick="shareEmergency('heimlich')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('heimlich')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 13: Ahogamiento -->
                <div class="emergency-card" onclick="openEmergencyDetail('ahogamiento')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="img/icons/drowning.png" alt="Ahogamiento">
                        <div class="emergency-badge">CRÍTICO</div>
                    </div>
                    <div class="card-content">
                        <h3>Rescate por Ahogamiento</h3>
                        <p class="description">Técnicas de rescate acuático y primeros auxilios para víctimas de ahogamiento.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 1-2 min</span>
                            <span class="stat">📱 Difícil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('ahogamiento')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('ahogamiento')">
                                <span id="favorite-ahogamiento">🤍</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('ahogamiento')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-ahogamiento">
                                <div class="dropdown-item" onclick="shareEmergency('ahogamiento')">📤 Compartir</div>
                                <div class="dropdown-item" onclick="reportEmergency('ahogamiento')">🚨 Reportar</div>
                            </div>
                        </div>
                    </div>
                </div>

        
            </div>
        </div>
    </div>

    <!-- Sección del mapa (inicialmente oculta) -->
    <div id="map-section" class="map-section" style="display: none;">
        <img src="img/mapa.png" alt="Mapa de hospitales">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7522.48882518072!2d-99.13258056190091!3d19.48811765043592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cdff8c00000000%3A0x1b5b45a44293f318!2sHospital%20Angeles%20Lindavista!5e0!3m2!1ses-419!2smx!4v1749667652056!5m2!1ses-419!2smx" 
            width="600" 
            height="450" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <!-- Sección de Historial (inicialmente oculta) -->
    <div id="historial-section" class="historial-section" style="display: none;">
        <div class="historial-container">
            <div class="page-title">
                <h2>📋 Registro de Incidente Médico</h2>
                <p>Formulario para registrar detalles de incidentes médicos</p>
            </div>
            
            <form class="incident-form" action="procesar_incidente.php" method="post">
                <div class="form-section">
                    <h3>Detalles del Incidente Médico</h3>
                    
                    <div class="form-group">
                        <label for="paciente">Nombre del paciente:</label>
                        <input type="text" id="paciente" name="paciente" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edad">Edad:</label>
                        <input type="number" id="edad" name="edad" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sintomas">Síntomas presentados:</label>
                        <textarea id="sintomas" name="sintomas" rows="3" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="diagnostico">Diagnóstico preliminar:</label>
                        <textarea id="diagnostico" name="diagnostico" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="tratamiento">Tratamiento aplicado:</label>
                        <textarea id="tratamiento" name="tratamiento" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="estado">Estado del paciente:</label>
                        <select id="estado" name="estado" required>
                            <option value="">-- Selecciona --</option>
                            <option value="estable">Estable</option>
                            <option value="crítico">Crítico</option>
                            <option value="trasladado">Trasladado</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="submit-btn">Enviar Incidente</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sección de Favoritos (inicialmente oculta) -->
    <div id="favoritos-section" class="favoritos-section" style="display: none;">
        <div class="favoritos-container">
            <div class="page-title">
                <h2>⭐ Favoritos</h2>
                <p>Contenido guardado en tus favoritos</p>
            </div>
            
            <div class="emergency-grid">
                <!-- Tarjeta 1: RCP (Favorito) -->
                <div class="emergency-card" onclick="openEmergencyDetail('rcp')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="https://img.icons8.com/color/96/heart-with-pulse.png" alt="RCP">
                        <div class="emergency-badge">CRÍTICO</div>
                    </div>
                    <div class="card-content">
                        <h3>Reanimación Cardiopulmonar (RCP)</h3>
                        <p class="description">Técnica de emergencia para salvar vidas cuando alguien ha dejado de respirar o su corazón ha dejado de latir.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 2-3 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('rcp')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('rcp')">
                                <span id="favorite-rcp">❤️</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('rcp-fav')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-rcp-fav">
                                <div class="dropdown-item" onclick="removeFromFavorites('rcp')">🗑️ Quitar de favoritos</div>
                                <div class="dropdown-item" onclick="downloadEmergency('rcp')">⬇️ Descargar</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta 2: Hemorragia (Favorito) -->
                <div class="emergency-card" onclick="openEmergencyDetail('hemorragia')" style="cursor: pointer;">
                    <div class="card-image">
                        <img src="https://img.icons8.com/color/96/blood-drop.png" alt="Hemorragia">
                        <div class="emergency-badge">URGENTE</div>
                    </div>
                    <div class="card-content">
                        <h3>Control de Hemorragias</h3>
                        <p class="description">Cómo detener el sangrado excesivo aplicando presión directa y elevando la herida.</p>
                        <div class="card-stats">
                            <span class="stat">⏱️ 1-2 min</span>
                            <span class="stat">📱 Fácil</span>
                        </div>
                    </div>
                    <div class="card-actions" onclick="event.stopPropagation();">
                        <div class="action-buttons">
                            <button class="action-btn download-btn" onclick="downloadEmergency('hemorragia')">
                                <span>⬇️</span>
                                Descargar
                            </button>
                            <button class="action-btn favorite-btn" onclick="toggleFavorite('hemorragia')">
                                <span id="favorite-hemorragia">❤️</span>
                                Favorito
                            </button>
                        </div>
                        <div class="more-options">
                            <button class="more-btn" onclick="showMoreOptions('hemorragia-fav')">⋯</button>
                            <div class="dropdown-menu" id="dropdown-hemorragia-fav">
                                <div class="dropdown-item" onclick="removeFromFavorites('hemorragia')">🗑️ Quitar de favoritos</div>
                                <div class="dropdown-item" onclick="downloadEmergency('hemorragia')">⬇️ Descargar</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón flotante de chat IA -->
    <button class="chat-ia-btn" onclick="openChatIA()">
        <img src="https://img.icons8.com/ios-filled/32/ffffff/chat.png" alt="Chat IA" class="chat-ia-icon">
        <span>Chat IA</span>
    </button>

    <!-- Modal del Chat IA -->
    <div id="chat-modal" class="chat-modal">
        <div class="chat-modal-content">
            <div class="chat-header">
                <div class="chat-title">
                    <img src="https://img.icons8.com/ios-filled/24/ffffff/robot.png" alt="IA" class="ai-icon">
                    <h3>Asistente IA Asclepio</h3>
                </div>
                <button class="close-chat" onclick="closeChatIA()">×</button>
            </div>
            <div class="chat-messages" id="chat-messages">
                <div class="message ai-message">
                    <div class="message-content">
                        <p>¡Hola! Soy tu asistente IA de Asclepio. ¿En qué puedo ayudarte hoy?</p>
                    </div>
                    <span class="message-time">Ahora</span>
                </div>
            </div>
            <div class="chat-input-container">
                <input type="text" id="chat-input" placeholder="Escribe tu mensaje..." onkeypress="handleChatInput(event)">
                <button class="send-btn" onclick="sendMessage()">
                    <img src="https://img.icons8.com/ios-filled/20/ffffff/sent.png" alt="Enviar">
                </button>
            </div>
        </div>
    </div>

    <script src="js/bot.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/emergency-detail.js"></script>
</body>
</html> 