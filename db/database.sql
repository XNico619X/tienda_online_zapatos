-- Script SQL para crear la base de datos y tablas de la tienda de zapatos.
CREATE DATABASE IF NOT EXISTS tienda_zapatos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE tienda_zapatos;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin','cliente') NOT NULL DEFAULT 'cliente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(180) NOT NULL,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(255) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(10,2) NOT NULL DEFAULT 0,
    total DECIMAL(10,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador', 'admin@tienda.com', '$2y$10$XKrUY0MVnJ0.bs8BVemG3OWayAGEmV3I.aP7lFBL/gPRbxf.s8lQi', 'admin'),
('Cliente de prueba', 'cliente@tienda.com', '$2y$10$Df0EEyxuUOLEjbYkm9UvguXJeCyxX/Mdd5LfLyysV1eXSO5A2BL4S', 'cliente');

INSERT INTO productos (nombre, precio, stock, imagen) VALUES
('Zapato Deportivo', 150000.00, 12, ''),
('Zapato Casual', 120000.00, 8, '');
