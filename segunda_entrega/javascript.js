function setup() {
    const canvas = document.getElementById("logo");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    const scale = canvas.width / 100;
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Configuración global de Neón
    ctx.shadowBlur = 15;
    ctx.lineJoin = "round";
    ctx.lineCap = "round";

    /*
        DIBUJO DE LA LOOT BOX (COFRE)
    */
    ctx.shadowColor = "#00D4FF";
    ctx.strokeStyle = "#00D4FF";
    ctx.lineWidth = 2.5 * scale;

    // Cuerpo principal del cofre (Hexágono estilizado)
    ctx.beginPath();
    ctx.moveTo(30 * scale, 40 * scale); // Top-left
    ctx.lineTo(70 * scale, 40 * scale); // Top-right
    ctx.lineTo(85 * scale, 55 * scale); // Right-mid
    ctx.lineTo(75 * scale, 80 * scale); // Bottom-right
    ctx.lineTo(25 * scale, 80 * scale); // Bottom-left
    ctx.lineTo(15 * scale, 55 * scale); // Left-mid
    ctx.closePath();
    ctx.stroke();

    // Tapa del cofre (Línea de apertura)
    ctx.beginPath();
    ctx.moveTo(15 * scale, 55 * scale);
    ctx.lineTo(85 * scale, 55 * scale);
    ctx.stroke();

    /*
        DETALLES DE "CÓDIGO" / CIRCUITOS
    */
    ctx.strokeStyle = "#39FF88";
    ctx.shadowColor = "#39FF88";
    ctx.lineWidth = 1.5 * scale;

    // Líneas de circuito laterales (Representando datos/códigos)
    const drawCircuit = (x, y, dir) => {
        ctx.beginPath();
        ctx.moveTo(x, y);
        ctx.lineTo(x + (5 * dir * scale), y - (5 * scale));
        ctx.lineTo(x + (15 * dir * scale), y - (5 * scale));
        ctx.stroke();
        // Nodo final
        ctx.beginPath();
        ctx.arc(x + (16 * dir * scale), y - (5 * scale), 1 * scale, 0, Math.PI * 2);
        ctx.stroke();
    };

    drawCircuit(20 * scale, 50 * scale, -1); // Izquierda
    drawCircuit(80 * scale, 50 * scale, 1);  // Derecha

    /*
        CERRADURA ELECTRÓNICA (CORE)
    */
    ctx.fillStyle = "#39FF88";
    ctx.shadowBlur = 20;
    
    // Rombo central brillante
    ctx.beginPath();
    ctx.moveTo(50 * scale, 50 * scale);
    ctx.lineTo(55 * scale, 55 * scale);
    ctx.lineTo(50 * scale, 60 * scale);
    ctx.lineTo(45 * scale, 55 * scale);
    ctx.closePath();
    ctx.fill();

    /*
        PIXEL BITS (LOOT CAYENDO)
    */
    ctx.shadowBlur = 5;
    const pixels = [
        {x: 40, y: 25}, {x: 55, y: 15}, {x: 65, y: 30}
    ];
    
    pixels.forEach(p => {
        ctx.fillRect(p.x * scale, p.y * scale, 3 * scale, 3 * scale);
    });

    /*
        TEXTO DE MARCA
    */
    ctx.shadowBlur = 12;
    ctx.fillStyle = "#00D4FF";
    ctx.font = `bold ${11 * scale}px 'Courier New', Courier, monospace`; // Fuente más "tech"
    ctx.textAlign = "center";
    ctx.fillText("CYBERLOOT", 50 * scale, 95 * scale);
}

window.addEventListener("DOMContentLoaded", function () {

    setup();

    buscarTienda();
});

function buscarTienda() {

    let mensaje =
        document.getElementById("mensaje-tienda");

    let mapa =
        document.getElementById("mapa-google");

    if (!mensaje || !mapa) return;

    if (navigator.geolocation) {

        mensaje.textContent =
            "Buscando tienda cercana...";

        navigator.geolocation.getCurrentPosition(

            function(posicion) {

                let lat = posicion.coords.latitude;

                let lon = posicion.coords.longitude;

                mensaje.textContent =
                    "Mostrando tienda más cercana.";

                mapa.src =
                    "https://maps.google.com/maps?q=gaming%20store%20near%20"
                    + lat + "," + lon +
                    "&z=13&output=embed";
            },

            function() {

                mensaje.textContent =
                    "No se pudo obtener la ubicación.";
            }
        );

    } else {

        mensaje.textContent =
            "Geolocalización no disponible.";
    }
}