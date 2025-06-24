// bot.js

let data = {};
fetch("data.json").then(res => res.json()).then(json => { data = json; });

// Función para normalizar texto
function normalizar(str) {
  return str.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

// Clasificador local
function clasificadorLocal(texto) {
  const textoNorm = normalizar(texto);
  const reglas = [
    { caso: "precauciones", patrones: [/\bprecaución\b/, /\bprecauciones?\b/, /\bproteger\b/, /\bmedidas\b/] },
    { caso: "quemaduras", patrones: [/\bquemadura(s)?( de piel)?\b/, /\bme queme\b/, /\bme ardí\b/, /\bagua caliente\b/] },
    { caso: "convulsiones", patrones: [/\bconvulsión( epiléptica)?\b/, /\bataque epiléptico\b/, /\btemblores\b/] },
    { caso: "shock", patrones: [/\bshock\b/, /\bpiel fría\b/, /\bpálido\b/, /\bpresion baja\b/] },
    { caso: "asfixia", patrones: [/\batragantamiento\b/, /\bno puedo respirar\b/, /\bme ahogo\b/] },
    { caso: "hemorragias", patrones: [/\bhemorragia(s)?\b/, /\bsangrado\b/, /\bsangre\b/] },
    { caso: "intoxicaciones", patrones: [/\bintoxicación\b/, /\bveneno\b/, /\bcomí algo raro\b/] },
    { caso: "fractura", patrones: [/\bfractura(s)?( ósea)?\b/, /\bme rompí\b/, /\bhueso roto\b/, /\bcaí desde\b/, /\bcayó\b/, /\bme golpee\b/, /\bse golpeo\b/] },
    { caso: "rcp", patrones: [/\brcp\b/, /\breanimación( cardiopulmonar)?\b/, /\bparo cardíaco\b/] },
    { caso: "dea", patrones: [/\bdea\b/, /\bdesfibrilador\b/] },
    { caso: "dificultad_respiratoria", patrones: [/\bdificultad para respirar\b/, /\bno puedo respirar\b/, /\basfixia\b/] },
    { caso: "ataque_cardiaco", patrones: [/\bataque( al)? corazón\b/, /\bdolor en el pecho\b/] },
    { caso: "alergias_graves", patrones: [/\balergia grave\b/, /\banafilaxia\b/, /\bhinchazón\b/, /\breacción alérgica\b/] },
    { caso: "heimlich", patrones: [/\bmaniobra heimlich\b/, /\bcompresión abdominal\b/, /\bhecho heimlich\b/] },
    { caso: "ahogamiento", patrones: [/\bahogamiento\b/, /\bme estoy ahogando\b/, /\bse ahogó\b/, /\btragó agua\b/, /\bsumergido\b/, /\bno respira tras nadar\b/] }
  ];
  for (const { caso, patrones } of reglas) {
    for (const regex of patrones) {
      if (regex.test(textoNorm)) return { caso, sugerencia: false };
    }
  }
  return null;
}


// Clasificador IA (llama a tu backend Hugging Face)
async function clasificadorIA(texto) {
  try {
    const respuesta = await fetch("http://localhost:3001/clasificar", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ texto })
    });
    const json = await respuesta.json();
    const score = json.scores?.[0];
    const label = json.labels?.[0];
    if (!score || !label) return null;
    if (score > 0.5) return { caso: label, sugerencia: false };
    if (score > 0.1) return { caso: label, sugerencia: true };
    return null;
  } catch (error) {
    console.error("Error en clasificadorIA:", error);
    return null;
  }
}

// Clasificación combinada (local + IA)
async function procesarTexto(texto) {
  const local = clasificadorLocal(texto);
  if (local) return local;
  return await clasificadorIA(texto);
}

// Agrega mensajes al chat
function addMessage(text, sender) {
  const messagesContainer = document.getElementById('chat-messages');
  const messageDiv = document.createElement('div');
  messageDiv.className = `message ${sender}-message`;

  const now = new Date();
  const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

  messageDiv.innerHTML = `
      <div class="message-content">
          <p>${text}</p>
      </div>
      <span class="message-time">${timeString}</span>
  `;

  messagesContainer.appendChild(messageDiv);
  messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Cierra el chat IA
function closeChatIA() {
  const modal = document.getElementById('chat-modal');
  if (modal) modal.style.display = 'none';
}

// Función para enviar mensaje, procesar y responder
async function sendMessage() {
  const input = document.getElementById('chat-input');
  const message = input.value.trim();
  if (!message) return;

  addMessage(message, 'user');
  input.value = '';

  const resultado = await procesarTexto(message);

  if (resultado) {
    const info = data[resultado.caso];
    if (!info) {
      addMessage("Lo siento, encontré un caso pero no tengo más información disponible.", 'ai');
      return;
    }

    if (resultado.sugerencia) {
      const sugerencia = document.createElement('div');
      sugerencia.className = 'message ai-message';
      sugerencia.innerHTML = `
          <div class="message-content">
              <p>❕ Sugerencia automática: ¿Quieres ver información sobre <strong>${resultado.caso.replace(/_/g, " ")}</strong>?</p>
              <button id="btn-si">Sí</button>
              <button id="btn-no">No</button>
          </div>
      `;
      document.getElementById('chat-messages').appendChild(sugerencia);
      sugerencia.scrollIntoView();

      document.getElementById('btn-si').addEventListener('click', () => {
        addMessage(`🩺 ${info.resumen}`, 'ai');
        sugerencia.remove();
        localStorage.setItem("casoSeleccionado", resultado.caso);
        const irAhora = confirm(`¿Quieres ver la información sobre "${resultado.caso.replace(/_/g, " ")}"?`);
        if (irAhora) {
          window.location.href = `emergency-detail.php?caso=${encodeURIComponent(resultado.caso)}`;
          closeChatIA();
        }
      });

      document.getElementById('btn-no').addEventListener('click', () => {
        addMessage("Entiendo. Intenta describir el caso con más detalle.", 'ai');
        sugerencia.remove();
      });

    } else {
      addMessage(`🩺 ${info.resumen}`, 'ai');
      localStorage.setItem("casoSeleccionado", resultado.caso);
      const irAhora = confirm(`¿Quieres ver la información sobre "${resultado.caso.replace(/_/g, " ")}"?`);
      if (irAhora) {
        window.location.href = `emergency-detail.php?caso=${encodeURIComponent(resultado.caso)}`;
        closeChatIA();
      }
    }
  } else {
    addMessage("Lo siento, no encontré un caso relacionado. ¿Podrías describirlo de otra manera?", 'ai');
  }
}

// Hacer sendMessage accesible desde menu.js
window.sendMessage = sendMessage;
window.closeChatIA = closeChatIA;
