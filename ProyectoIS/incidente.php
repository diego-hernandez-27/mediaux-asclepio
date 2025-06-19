<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Asclepio - Incidente</title>
  <link href="css/style2.css" rel="stylesheet" />
</head>
<body>

<div class="header">
    <div class="logo-title">
      <img src="images/logo.png" alt="Logo Asclepio" class="logo">
      <h1>ASCLEPIO</h1>
    </div>
    <div class="user-profile">
      <span class="username">Username</span>
      <img src="https://i.imgur.com/4ZQeZsK.png" alt="Profile" class="profile-pic">
    </div>
  </div>

<div class="navbar">
  <a href="notas.html" class="icon">
    <img src="https://img.icons8.com/ios/24/pen.png"/><p class = "pls">Notas</p>
  </a>
  <a href="historial.html" class="icon">
    <img src="https://img.icons8.com/ios/24/clock.png"/><p class = "pls">Historial</p>
  </a>
  <a href="mapa.html" class="icon">
    <img src="https://img.icons8.com/ios/24/map.png"/><p class = "pls">Mapa</p>
  </a>
  <a href="nube.html" class="icon">
    <img src="https://img.icons8.com/ios/24/cloud.png"/><p class = "pls">Nube</p>
  </a>
  <a href="favoritos.html" class="icon">
    <img src="https://img.icons8.com/ios/24/star.png"/><p class = "pls">Favoritos</p>
  </a>
</div>

<main>
  <h2>INCIDENTE</h2>
 
  <form class="form-section" action="procesar_incidente.php" method="post">
    <h3>Detalles del Incidente Médico</h3>

    <label for="paciente">Nombre del paciente:</label>
    <input type="text" id="paciente" name="paciente" required>

    <label for="edad">Edad:</label>
    <input type="number" id="edad" name="edad" min="0" required>

    <label for="sintomas">Síntomas presentados:</label>
    <textarea id="sintomas" name="sintomas" rows="3" required></textarea>

    <label for="diagnostico">Diagnóstico preliminar:</label>
    <textarea id="diagnostico" name="diagnostico" rows="3"></textarea>

    <label for="tratamiento">Tratamiento aplicado:</label>
    <textarea id="tratamiento" name="tratamiento" rows="3"></textarea>

    <label for="estado">Estado del paciente:</label>
    <select id="estado" name="estado" required>
      <option value="">-- Selecciona --</option>
      <option value="estable">Estable</option>
      <option value="crítico">Crítico</option>
      <option value="trasladado">Trasladado</option>
    </select>

    <button type="submit">Enviar</button>
  </form>
</main>

<img src="https://upload.wikimedia.org/wikipedia/commons/8/80/OpenAI_Logo.svg" class="bottom-logo" alt="Logo inferior">

</body>

<footer class="footer">
  <div class="footer-left">
    © 2025 Proyecto de Asclepio Ingeniería de Software 6CM3
  </div>
  <div class="footer-right">
    <a href="https://github.com" target="_blank"><img src="https://img.icons8.com/ios-glyphs/16/000000/github.png"/> Documentación</a>
    <a href="acerca.html"><img src="https://img.icons8.com/ios-glyphs/16/000000/info.png"/> Acerca de</a>
    <a href="contacto.html"><img src="https://img.icons8.com/ios-glyphs/16/000000/secured-letter.png"/> Contacto</a>
  </div>
</footer>

</html>
