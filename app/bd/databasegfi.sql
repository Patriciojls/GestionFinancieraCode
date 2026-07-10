-- ============================================================================
-- Proyecto: Gestión Financiera Integral (GFI)
-- Descripción: Este modelo permite gestionar usuarios, sus planes de membresía, 
--              así como el control detallado de sus finanzas (ingresos, gastos, 
--              deudas, metas de ahorro y testimonios).
-- ============================================================================

-- Crea la base de datos solo si no existe para evitar errores de duplicación.
CREATE DATABASE IF NOT EXISTS gfi_db;
USE gfi_db;

-- Propósito: Almacena la información de perfil y credenciales de los usuarios.
CREATE TABLE USUARIO (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    
    nombre VARCHAR(100) NOT NULL,
    
    correo VARCHAR(150) NOT NULL UNIQUE,
    
    -- password_hash: Contraseña encriptada por seguridad (nunca en texto plano). Espacio suficiente para algoritmos como BCrypt.
    password_hash VARCHAR(255) NOT NULL,
    
    fecha_registro DATE NOT NULL,
    
    -- estado: Controla si el usuario está 'Activo', 'Suspendido' o 'Inactivo'. Por defecto inicia 'Activo'.
    estado VARCHAR(20) NOT NULL DEFAULT 'Activo'
);

-- Propósito: Catálogo de los planes o niveles de suscripción que ofrece la plataforma (ej. Gratis, Premium, Pro).
CREATE TABLE MEMBRESIA (
    id_membresia INT AUTO_INCREMENT PRIMARY KEY,
    
    nombre_plan VARCHAR(50) NOT NULL,
    
    precio_mensual DECIMAL(10,2) NOT NULL,
    
    duracion_meses INT NOT NULL,
    
    -- caracteristicas: Texto libre para describir los beneficios incluidos en el plan.
    caracteristicas TEXT
);

-- Propósito: Tabla intermedia (Muchos a Muchos) que registra qué usuarios tienen 
--            qué membresía, junto con su historial de vigencia y pagos.
CREATE TABLE SUSCRIPCION (
    id_suscripcion INT AUTO_INCREMENT PRIMARY KEY,
    
    id_usuario INT NOT NULL,
    
    id_membresia INT NOT NULL,
    
    -- fecha_inicio / fecha_fin: Definen la ventana de tiempo en la que el servicio estará activo.
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    
    -- estado_pago: Estado de la transacción (ej. 'Pagado', 'Pendiente', 'Rechazado').
    estado_pago VARCHAR(50) NOT NULL,
    
    -- ON DELETE CASCADE: Si se borra un usuario, se eliminan automáticamente sus registros de suscripción.
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE,
    
    -- Restricción normal: No se puede borrar una membresía si hay usuarios suscritos a ella.
    FOREIGN KEY (id_membresia) REFERENCES MEMBRESIA(id_membresia)
);

-- Propósito: Registra las entradas de dinero de cada usuario (ej. salario, inversiones).
CREATE TABLE INGRESO (
    id_ingreso INT AUTO_INCREMENT PRIMARY KEY,
    
    id_usuario INT NOT NULL,
    
    -- monto: Cantidad de dinero ingresada.
    monto DECIMAL(10,2) NOT NULL,
    
    fecha DATE NOT NULL,
    
    -- descripcion: Nota opcional para dar contexto (ej. 'Bono de fin de año').
    descripcion VARCHAR(255),
    
    -- categoria: Clasificación del ingreso (ej. 'Nómina', 'Freelance', 'Ventas').
    categoria VARCHAR(50) NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);

-- Propósito: Registra las salidas de dinero o egresos del usuario para su balance financiero.
CREATE TABLE GASTO_PERSONAL (
    id_gasto_pers INT AUTO_INCREMENT PRIMARY KEY,
    
    id_usuario INT NOT NULL,
    
    -- monto: Cantidad de dinero gastada.
    monto DECIMAL(10,2) NOT NULL,
    
    -- categoria: Clasificación del egreso (ej. 'Alimentación', 'Transporte', 'Entretenimiento').
    categoria VARCHAR(50) NOT NULL,
    
    -- fecha: Día en que se efectuó el gasto.
    fecha DATE NOT NULL,
    
    descripcion VARCHAR(255),
    
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);

-- Propósito: Permite al usuario trackear sus pasivos financieros (créditos, préstamos).
CREATE TABLE DEUDA (
    id_deuda INT AUTO_INCREMENT PRIMARY KEY,
    
    -- id_usuario: El deudor.
    id_usuario INT NOT NULL,
    
    -- monto_total: El capital inicial prestado.
    monto_total DECIMAL(10,2) NOT NULL,
    
    -- saldo_pendiente: Lo que falta por pagar actualmente (irá disminuyendo con los abonos).
    saldo_pendiente DECIMAL(10,2) NOT NULL,
    
    -- tasa_interes_anual: Porcentaje de interés (ej. 14.50%). El tipo DECIMAL(5,2) permite valores como 100.00.
    tasa_interes_anual DECIMAL(5,2) NOT NULL,
    
    -- pago_mensual: Cuota mínima o estimada que debe pagar al mes.
    pago_mensual DECIMAL(10,2) NOT NULL,
    
    -- fecha_inicio: Cuándo se contrajo la obligación financiera.
    fecha_inicio DATE NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);

-- Propósito: Gestión de objetivos de ahorro (ej. 'Fondo de emergencia', 'Comprar coche').
CREATE TABLE META (
    id_meta INT AUTO_INCREMENT PRIMARY KEY,
    
    -- id_usuario: El usuario que se propone la meta.
    id_usuario INT NOT NULL,
    
    -- descripcion: Nombre u objetivo de la meta.
    descripcion VARCHAR(255) NOT NULL,
    
    -- monto_objetivo: La cifra total que se quiere alcanzar.
    monto_objetivo DECIMAL(10,2) NOT NULL,
    
    -- monto_actual_ahorrado: El progreso actual. Empieza en 0.00 por defecto.
    monto_actual_ahorrado DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    
    -- fecha_limite: Fecha máxima estimada para cumplir el objetivo.
    fecha_limite DATE NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);

-- Propósito: Almacena las opiniones, reviews y feedback que los usuarios dejan 
--            sobre la aplicación para control interno o mostrar en la Landing Page.
CREATE TABLE TESTIMONIOS (
    id_testimonio INT AUTO_INCREMENT PRIMARY KEY,
    
    id_usuario INT NOT NULL,
    
    comentario TEXT NOT NULL,
    
    -- calificacion: Puntuación del 1 al 5. La restricción CHECK asegura que no se inserten números fuera de ese rango.
    calificacion INT NOT NULL CHECK (calificacion BETWEEN 1 AND 5),
    
    -- fecha_publicacion: Cuándo se escribió el testimonio.
    fecha_publicacion DATE NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES USUARIO(id_usuario) ON DELETE CASCADE
);