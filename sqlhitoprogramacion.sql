CREATE DATABASE streamweb;
USE streamweb;

 -- las tablas
CREATE TABLE planes (
    id_plan INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio_mensual DECIMAL(5, 2) NOT NULL
);

CREATE TABLE paquetes (
    id_paquete INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio_mensual DECIMAL(5, 2) NOT NULL
);

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    edad INT NOT NULL,
    id_plan INT NOT NULL,
    duracion ENUM('mensual', 'anual') NOT NULL,
    FOREIGN KEY (id_plan) REFERENCES planes(id_plan)
);

CREATE TABLE usuario_paquetes (
    id_usuario INT NOT NULL,
    id_paquete INT NOT NULL,
    PRIMARY KEY (id_usuario, id_paquete),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_paquete) REFERENCES paquetes(id_paquete)
);

INSERT INTO planes (nombre, precio_mensual)
VALUES ('Básico', 9.99), ('Estándar', 13.99), ('Premium', 17.99);

INSERT INTO paquetes (nombre, precio_mensual)
VALUES ('Deporte', 6.99), ('Cine', 7.99), ('Infantil', 4.99);

