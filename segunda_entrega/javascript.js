function setup() {
    const canvas = document.getElementById("logo");
    if (!canvas) return;
    const ctx = canvas.getContext("2d");
    const white = "#F3F3F1";
    
    // Escalado para mantener proporciones en diferentes tamaños de canvas
    const scale = canvas.width / 100;

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

window.onload = function () {
    buscarTienda();
};

function buscarTienda() {
    let mensaje = document.getElementById("mensaje-tienda");
    let mapa = document.getElementById("mapa-google");

    if (!mensaje || !mapa) return;

    if (navigator.geolocation) {
        mensaje.textContent = "Buscando tienda cercana...";

        navigator.geolocation.getCurrentPosition(
            function(posicion) {
                let lat = posicion.coords.latitude;
                let lon = posicion.coords.longitude;

                mensaje.textContent = "Mostrando tienda más cercana.";

                mapa.src =
                    "https://maps.google.com/maps?q=tienda%20videojuegos%20near%20"
                    + lat + "," + lon +
                    "&z=13&output=embed";
            },

            function() {
                mensaje.textContent = "No se pudo obtener la ubicación.";
            }
        );
    } else {
        mensaje.textContent = "Geolocalización no disponible.";
    }
}