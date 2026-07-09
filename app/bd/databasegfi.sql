-- ============================================
-- Script de creación de base de datos
-- Proyecto: Gestión Financiera Integral (GFI)
-- ============================================

CREATE DATABASE IF NOT EXISTS gfi_db;
USE gfi_db;

-- Tabla: USUARIO
CREATE TABLE USUARIO (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    fecha_registro DATE NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'Activo'
);

-- Tabla: MEMBRESIA
CREATE TABLE MEMBRESIA (
    id_membresia INT AUTO_INCREMENT PRIMARY KEY,
    nombre_plan VARCHAR(50) NOT NULL,
    precio_mensual DECIMAL(10,2) NOT NULL,
    duracion_meses INT NOT NULL,
    caracteristicas TEXT
);

-- Tabla: SUSCRIPCION
CREATE TABLE SUSCRIPCION (
    id_suscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_membresia INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    estado_pago VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_membresia) REFERENCES MEMBRESIA(id_membresia)
);

-- Tabla: INGRESO
CREATE TABLE INGRESO (
    id_ingreso INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    fecha DATE NOT NULL,
    descripcion VARCHAR(255),
    categoria VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);

-- Tabla: GASTO_PERSONAL
CREATE TABLE GASTO_PERSONAL (
    id_gasto_pers INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    descripcion VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);

-- Tabla: DEUDA
CREATE TABLE DEUDA (
    id_deuda INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    monto_total DECIMAL(10,2) NOT NULL,
    saldo_pendiente DECIMAL(10,2) NOT NULL,
    tasa_interes_anual DECIMAL(5,2) NOT NULL,
    pago_mensual DECIMAL(10,2) NOT NULL,
    fecha_inicio DATE NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);

-- Tabla: META
CREATE TABLE META (
    id_meta INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    monto_objetivo DECIMAL(10,2) NOT NULL,
    monto_actual_ahorrado DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    fecha_limite DATE NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);

-- Tabla: TESTIMONIOS
CREATE TABLE TESTIMONIOS (
    id_testimonio INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    comentario TEXT NOT NULL,
    calificacion INT NOT NULL CHECK (calificacion BETWEEN 1 AND 5),
    fecha_publicacion DATE NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);