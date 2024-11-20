CREATE DATABASE homedesign_db;

USE homedesign_db;

CREATE TABLE usuarios (
    id_usuario VARCHAR(30) PRIMARY KEY NOT NULL,
    password VARCHAR(30) NOT NULL,
    email VARCHAR(20) NOT NULL,
    nombre VARCHAR(30) NOT NULL,
    apellido VARCHAR(30) NOT NULL,
    dni INT NOT NULL,
    telefono INT,
    direccion VARCHAR(30) NOT NULL,
    codigo_postal INT NOT NULL,
    localidad VARCHAR(30) NOT NULL,
    provincia VARCHAR(30) NOT NULL
);

CREATE TABLE productos (
	codigo_producto INT PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL,
	precio DECIMAL(10, 2) NOT NULL,
	stock INT NOT NULL
	);

CREATE TABLE compras (
	id_compra INT PRIMARY KEY,
	id_usuario VARCHAR(30) NOT NULL,
	total_compra INT NOT NULL,
	nro_ticket INT NOT NULL,
	FOREIGN KEY (id_usuario) REFERENCES Usuarios (id_usuario)
	);

CREATE TABLE items_x_compra (
    id_compra INT NOT NULL,
	id_usuario VARCHAR(30) NOT NULL,
    codigo_producto INT NOT NULL,
    cantidad_comprada INT NOT NULL,
    precio_item DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (id_compra, id_usuario, codigo_producto),
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario),
    FOREIGN KEY (codigo_producto) REFERENCES productos (codigo_producto)
);

-- Creación de usuarios
INSERT INTO usuarios (id_usuario, password, email, nombre, apellido, dni, telefono, direccion, codigo_postal, localidad, provincia)
VALUES ('e', 'e', 'e@example.com', 'NombreEjemplo', 'ApellidoEjemplo', 12345678, 123456789, 'DireccionEjemplo', 12345, 'LocalidadEjemplo', 'ProvinciaEjemplo');
-- Creación de productos
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (1, 'Olso', 330000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (2, 'Rusti', 660000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (3, 'Eira 5', 830000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (10, 'Sofá Mestra', 1200000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (11, 'Sofá Lerk', 989700.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (12, 'Sofá Meet', 879300.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (20, 'Mesa Viena', 2300000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (21, 'Mesa Elit', 2550000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (22, 'Mesa Lecto', 2800000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (30, 'Poltrón Dion', 255000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (31, 'Poltrón Franca', 352000.00, 10);
INSERT INTO productos (codigo_producto, nombre, precio, stock) VALUES (32, 'Poltrón Frida', 355000.00, 10);
