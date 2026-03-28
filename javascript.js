function setup() {
    const canvas = document.getElementById("logo");
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    const white = "#F3F3F1";

    // Limpiar el canvas antes de dibujar
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Luna
    ctx.beginPath();
    ctx.arc(45, 50, 40, 0, Math.PI * 2); 
    ctx.fillStyle = white;
    ctx.fill();
    ctx.globalCompositeOperation = 'destination-out';
    ctx.beginPath();
    ctx.arc(58, 45, 38, 0, Math.PI * 2);
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
    estrellas(22, 35, 12); 
    ctx.fill();
    estrellas(16, 50, 8); 
    ctx.fill();
    estrellas(45, 82, 10); 
    ctx.fill();


    ctx.globalCompositeOperation = 'source-over';

    ctx.fillStyle = white;
    ctx.textAlign = "left"; 

    //Texto
    ctx.font = "bold 52px Georgia, serif";
    ctx.fillText("D", 30, 55);

    ctx.font = "bold 32px Georgia, serif";
    ctx.fillText("S", 60, 75);
}

window.addEventListener("DOMContentLoaded", setup);