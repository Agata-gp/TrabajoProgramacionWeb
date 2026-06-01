DROP DATABASE IF EXISTS cyberloot;
CREATE DATABASE IF NOT EXISTS cyberloot;
USE cyberloot;

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'admin') DEFAULT 'cliente'
);

CREATE TABLE IF NOT EXISTS productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    stock INT DEFAULT 0,
    categoria VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(20) DEFAULT 'activo',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE IF NOT EXISTS carrito_productos (
    id_carrito_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_carrito INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    FOREIGN KEY (id_carrito) REFERENCES carrito(id_carrito),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('completado', 'cancelado') DEFAULT 'completado',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
 
CREATE TABLE IF NOT EXISTS pedido_productos (
    id_pedido_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    nombre_producto VARCHAR(100) NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- Usuarios por defecto (contraseñas en producción deben usar password_hash)
INSERT IGNORE INTO usuarios (nombre, email, password, rol) VALUES 
('Admin', 'admin@cyberloot.com', 'admin', 'admin'),
('Cliente', 'cliente@cyberloot.com', 'cliente', 'cliente');

-- Productos de ejemplo
INSERT IGNORE INTO productos (nombre, descripcion, precio, imagen, stock, categoria) VALUES
('EA FC 26', 'Videojuego deportivo para consola y PC. La nueva entrega de la saga futbolística.', 29.99, 'imagenes/EA_FC.jpg', 50, 'videojuegos'),
('Mario Galaxy', 'Construye, explora y juega con tus amigos en un mundo sin límites.', 19.99, 'imagenes/marioGalaxy.jpg', 100, 'videojuegos'),
('Doom Eternal', 'Acción frenética en primera persona. Elimina hordas de demonios.', 39.99, 'imagenes/doom.jpg', 30, 'videojuegos'),
('Far Cry 7', 'Aventura en mundo abierto con una historia épica.', 49.99, 'imagenes/farcry.jpg', 25, 'videojuegos'),
('BioShock Remastered', 'La colección clásica de BioShock en versión remasterizada.', 24.99, 'imagenes/bioshock.jpg', 40, 'videojuegos'),
('Mickey Castle Illusion', 'El juego más emocionante de la saga Mickey Mouse.', 24.99, 'imagenes/mickeyGame.jpg', 40, 'videojuegos'),
('Tarjeta Steam 10€', 'Recarga tu cuenta de Steam al instante con 10 euros.', 10.00, 'imagenes/steam_10.jpg', 999, 'tarjetas'),
('Tarjeta Steam 20€', 'Recarga tu cuenta de Steam al instante con 20 euros.', 20.00, 'imagenes/steam_20.jpg', 999, 'tarjetas'),
('Tarjeta PSN 50€', 'Saldo para PlayStation Store, 50 euros.', 50.00, 'imagenes/psn_50.jpg', 999, 'tarjetas'),
('Tarjeta Xbox 25€', 'Saldo para Xbox Store, 25 euros.', 25.00, 'imagenes/xbox_25.jpg', 999, 'tarjetas'),
('Skin Valorant - Pack Reaver', 'Pack exclusivo para personalizar tus armas en Valorant.', 14.99, 'imagenes/skin_valorant_reaver.jpg', 200, 'skins'),
('Skin Fortnite - Omega', 'Aspecto especial de nivel máximo para tu personaje.', 9.99, 'imagenes/skin_fornite_omega.jpg', 150, 'skins'),
('Skin CS2 - AK-47 Neon', 'Skin neón para AK-47 en Counter-Strike 2.', 7.99, 'imagenes/skin_cs2_ak47_neon.jpg', 100, 'skins');
