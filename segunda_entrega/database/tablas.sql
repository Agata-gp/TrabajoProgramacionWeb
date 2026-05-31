CREATE DATABASE cyberloot;
USE cyberloot;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('cliente', 'admin') DEFAULT 'cliente'
);

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    stock INT DEFAULT 0,
    categoria VARCHAR(50)
);

CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(20) DEFAULT 'activo',

    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE carrito_productos (
    id_carrito_producto INT AUTO_INCREMENT PRIMARY KEY,
    id_carrito INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,

    FOREIGN KEY (id_carrito) REFERENCES carrito(id_carrito),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

INSERT INTO usuarios (nombre, email, password, rol)
VALUES 
('Administrador', 'admin@cyberloot.com', 'admin', 'admin'),
('Cliente', 'cliente@cyberloot.com', 'cliente', 'cliente');