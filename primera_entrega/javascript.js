function setup() {
    const canvas = document.getElementById("logo");
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    const white = "#F3F3F1";
    
    // Apply scale only on carrito and productos pages
    const currentPage = window.location.pathname;
    const scale = (currentPage.includes('carrito') || currentPage.includes('productos')) ? 0.6 : 1;

    // Limpiar el canvas antes de dibujar
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Luna
    ctx.beginPath();
    ctx.arc(45 * scale, 50 * scale, 40 * scale, 0, Math.PI * 2); 
    ctx.fillStyle = white;
    ctx.fill();
    ctx.globalCompositeOperation = 'destination-out';
    ctx.beginPath();
    ctx.arc(58 * scale, 45 * scale, 38 * scale, 0, Math.PI * 2);
    ctx.fill();


    //Funcion para dibujar estrellas con curvas

    function estrellas(x, y, size) {
        ctx.beginPath();
        ctx.moveTo(x, y - size);
        ctx.quadraticCurveTo(x, y, x + size, y);
        ctx.quadraticCurveTo(x, y, x, y + size);
        ctx.quadraticCurveTo(x, y, x - size, y);
        ctx.quadraticCurveTo(x, y, x, y - size);
        ctx.closePath();
    }
    
    // Estrellas
    estrellas(22 * scale, 35 * scale, 12 * scale); 
    ctx.fill();
    estrellas(16 * scale, 50 * scale, 8 * scale); 
    ctx.fill();
    estrellas(45 * scale, 82 * scale, 10 * scale); 
    ctx.fill();


    ctx.globalCompositeOperation = 'source-over';

    ctx.fillStyle = white;
    ctx.textAlign = "left"; 

    //Texto
    ctx.font = `bold ${52 * scale}px Georgia, serif`;
    ctx.fillText("D", 30 * scale, 55 * scale);

    ctx.font = `bold ${32 * scale}px Georgia, serif`;
    ctx.fillText("S", 60 * scale, 75 * scale);
}

window.addEventListener("DOMContentLoaded", setup);