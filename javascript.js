function setup() {
    const canvas = document.getElementById("logo");
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    const purple = "#4b1f6f"; // Morado oscuro original

    // 1. Limpieza total del lienzo de 100x100
    ctx.clearRect(0, 0, canvas.width, canvas.height);


    // --- 2. CREAR LA LUNA POR SUSTRACCIÓN ---
    
    // Primero, dibujamos el círculo base (Morado)
    ctx.beginPath();
    // Centro (45, 50), Radio 40
    ctx.arc(45, 50, 40, 0, Math.PI * 2); 
    ctx.fillStyle = purple;
    ctx.fill();

    // Cambiamos el modo a "Goma de Borrar" (DIBUJO DE RECORTE)
    ctx.globalCompositeOperation = 'destination-out';

    // Dibujamos el segundo círculo que va a "restar" para dar forma de C
    ctx.beginPath();
    // Lo movemos un poco a la derecha (58) y arriba (45)
    ctx.arc(58, 45, 38, 0, Math.PI * 2);
    ctx.fill();


    // --- 3. CREAR LAS ESTRELLAS COMO RECORTE (TRANSPARENTES) ---

    // Definimos una función auxiliar para dibujar la forma del brillo
    function drawSparklePath(x, y, size) {
        ctx.beginPath();
        // Efecto cóncavo (sparkle) de 4 puntas
        ctx.moveTo(x, y - size);
        ctx.quadraticCurveTo(x, y, x + size, y);
        ctx.quadraticCurveTo(x, y, x, y + size);
        ctx.quadraticCurveTo(x, y, x - size, y);
        ctx.quadraticCurveTo(x, y, x, y - size);
        ctx.closePath();
    }

    // Dibujamos los "recortes" de las estrellas (Mismo modo 'destination-out')
    
    // Estrella Superior (Aumentada a size 12)
    drawSparklePath(22, 35, 12); 
    ctx.fill();

    // Estrella Media (Aumentada a size 8)
    drawSparklePath(16, 50, 8); 
    ctx.fill();

    // Estrella Inferior (Aumentada a size 10)
    // (Ajustada su posición para que no se superponga demasiado)
    drawSparklePath(45, 82, 10); 
    ctx.fill();


    // --- 4. TEXTO (D S) MORADO (NORMAL) ---

    // IMPORTANTE: Volvemos al modo normal para dibujar el texto morado
    ctx.globalCompositeOperation = 'source-over';

    ctx.fillStyle = purple;
    ctx.textAlign = "left"; // Alineación izquierda para precisión

    // Configuración de la "D" (grande y arriba)
    ctx.font = "bold 52px Georgia, serif";
    //fillText(texto, x, y) - la 'y' es la línea de base
    ctx.fillText("D", 30, 55);

    // Configuración de la "S" (más pequeña y abajo)
    ctx.font = "bold 32px Georgia, serif";
    ctx.fillText("S", 60, 75);
}

window.addEventListener("DOMContentLoaded", setup);