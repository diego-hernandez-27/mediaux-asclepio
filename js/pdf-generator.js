// Función para generar PDF de una tarjeta de emergencia
function generatePDF(card) {
    // Crear un nuevo PDF
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Obtener el contenido de la tarjeta
    const title = card.querySelector('h3').textContent;
    const description = card.querySelector('.description').textContent;
    const stats = Array.from(card.querySelectorAll('.stat')).map(stat => stat.textContent);
    
    // Buscar los pasos en el detalle de la emergencia
    const emergencyDetail = document.querySelector('.emergency-detail');
    const steps = [];
    if (emergencyDetail) {
        const stepElements = emergencyDetail.querySelectorAll('.step');
        stepElements.forEach(step => {
            const stepNumber = step.querySelector('.step-number').textContent;
            const stepContent = step.querySelector('.step-content').textContent;
            steps.push(`${stepNumber}: ${stepContent}`);
        });
    }
    
    // Configuración básica
    const margin = 20;
    const lineSpacing = 12;
    
    // Título simple y grande
    doc.setFontSize(24);
    doc.setFont('helvetica', 'bold');
    doc.text(title, margin, 30);
    
    // Espacio después del título
    doc.text('', margin, 45);
    
    // Descripción con saltos de línea
    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');
    
    // Dividir el texto en líneas más pequeñas
    const descLines = doc.splitTextToSize(description, 170);
    
    // Imprimir cada línea
    let y = 50;
    descLines.forEach(line => {
        doc.text(line, margin, y);
        y += lineSpacing;
    });
    
    // Espacio después de la descripción
    doc.text('', margin, y + 10);
    
    // Estadísticas en una línea
    doc.setFontSize(10);
    doc.text(stats.join(' • '), margin, y + 15);
    
    // Espacio después de las estadísticas
    doc.text('', margin, y + 25);
    
    // Pasos si existen
    if (steps.length > 0) {
        y += 10;
        doc.setFontSize(14);
        doc.setFont('helvetica', 'bold');
        doc.text('Pasos a seguir:', margin, y);
        
        y += 15;
        doc.setFontSize(12);
        doc.setFont('helvetica', 'normal');
        
        // Imprimir cada paso
        steps.forEach(step => {
            doc.text(step, margin, y);
            y += lineSpacing;
        });
        
        y += 10;
    }
    
    // Agregar la imagen si existe
    const img = card.querySelector('img');
    if (img) {
        const imgData = img.src;
        const imgBase64 = imgData.replace(/^data:image\/\w+;base64,/, "");
        
        // Ajustar la imagen para que se vea mejor
        const imgWidth = 150;
        const imgHeight = img.naturalHeight * (imgWidth / img.naturalWidth);
        
        // Posicionar la imagen centrada
        const imgX = (210 - imgWidth) / 2;
        doc.addImage(imgBase64, 'JPEG', imgX, y + 20, imgWidth, imgHeight);
    }
    
    // Generar el nombre del archivo
    const fileName = title.replace(/[^a-zA-Z0-9]/g, '_') + '.pdf';
    
    // Guardar el PDF
    doc.save(fileName);
}

// Función para manejar el botón de descarga
function downloadEmergency(cardId) {
    // Encontrar la tarjeta original
    const originalCard = document.querySelector(`[data-id="${cardId}"]`);
    if (!originalCard) return;
    
    // Generar el PDF
    generatePDF(originalCard);
}

// Inicializar los botones de descarga
document.addEventListener('DOMContentLoaded', function() {
    // Agregar manejadores de eventos a los botones de descarga
    const downloadButtons = document.querySelectorAll('.download-btn');
    downloadButtons.forEach(button => {
        // Remover cualquier evento onclick existente
        button.onclick = null;
        
        // Agregar el nuevo evento
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.emergency-card');
            if (card) {
                generatePDF(card);
            }
        });
    });
});
