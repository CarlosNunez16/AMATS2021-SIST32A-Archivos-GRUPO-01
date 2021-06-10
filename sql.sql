CREATE DATABASE inventario_DB;
USE inventario_DB;

CREATE TABLE usuarios (
carnet INT NOT NULL,
nombres VARCHAR (100) NOT NULL,
apellidos VARCHAR (100) NOT NULL,
correo VARCHAR (100) NOT NULL,
direccion VARCHAR (200) NOT NULL,
contraseña VARCHAR (75) NOT NULL,
tipo_usuario VARCHAR (50) NOT NULL,
carrera VARCHAR (500),
cantidad_reportes INT,
PRIMARY KEY (carnet)
);

CREATE TABLE grupos (
idGrupo INT NOT NULL AUTO_INCREMENT,
nombre VARCHAR (100) NOT NULL,
descripcion VARCHAR (200),
PRIMARY KEY (idGrupo)
);

CREATE TABLE subgrupos (
idSubgrupo INT NOT NULL AUTO_INCREMENT,
idGrupo_FK INT NOT NULL,
nombre VARCHAR (100) NOT NULL,
descripcion VARCHAR (200),
FOREIGN KEY (idGrupo_FK) REFERENCES grupos (idGrupo),
PRIMARY KEY (idSubgrupo)
);

CREATE TABLE inventario (
idActivo INT NOT NULL AUTO_INCREMENT,
idGrupo_FK2 INT NOT NULL,
FOREIGN KEY (idGrupo_FK2) REFERENCES grupos (idGrupo),
idSubgrupo_FK INT NOT NULL,
FOREIGN KEY (idSubgrupo_fk) REFERENCES subgrupos (idSubgrupo),
nombre VARCHAR (100) NOT NULL,
marca VARCHAR (100) NOT NULL,
modelo VARCHAR (100) NOT NULL,
color VARCHAR (100) NOT NULL,
numero_serie VARCHAR (100) NOT NULL,
carnet_FK INT NOT NULL,
FOREIGN KEY (carnet_FK) REFERENCES usuarios (carnet),
ubicacion VARCHAR (100) NOT NULL,
fecha_asignacion VARCHAR (100) NOT NULL,
calidad VARCHAR (100) NOT NULL,
PRIMARY KEY (idActivo)
);

CREATE TABLE prestamo (
idPrestamo INT NOT NULL AUTO_INCREMENT,
carnet_FK2 INT NOT NULL,
FOREIGN KEY (carnet_FK2) REFERENCES usuarios (carnet),
idActivo_FK INT NOT NULL,
FOREIGN KEY (idActivo_FK) REFERENCES inventario (idActivo),
fecha_prestamo VARCHAR (100) NOT NULL,
hora_pretamo VARCHAR (100) NOT NULL,
fecha_entrega VARCHAR (100) NOT NULL,
estado VARCHAR (100) NOT NULL,
calidad_entrega VARCHAR (100),
PRIMARY KEY (idPrestamo)
);

CREATE TABLE reportes (
idDanos INT NOT NULL AUTO_INCREMENT,
idPrestamo_FK INT NOT NULL,
FOREIGN KEY (idPrestamo_FK) REFERENCES prestamo (idPrestamo),
fecha VARCHAR (100) NOT NULL,
detalles VARCHAR (300) NOT NULL,
PRIMARY KEY (idDanos)
);

CREATE TABLE mantenimientos (
idMantenimiento INT NOT NULL AUTO_INCREMENT,
idActivo_FK2 INT NOT NULL,
FOREIGN KEY (idActivo_FK2) REFERENCES inventario (idActivo),
fecha VARCHAR (100) NOT NULL,
detalles VARCHAR (500) NOT NULL,
refacciones VARCHAR (500) NOT NULL,
carnet_FK3 INT NOT NULL,
FOREIGN KEY (carnet_FK3) REFERENCES usuarios (carnet),
total VARCHAR (100) NOT NULL, 
justificacion VARCHAR (300) NOT NULL,
tiempo VARCHAR (100) NOT NULL,
proximo_mantenimiento VARCHAR (100) NOT NULL,
calidad_nueva VARCHAR (100) NOT NULL,
PRIMARY KEY (idMantenimiento)
);

CREATE TABLE refacciones (
idRefacciones INT NOT NULL AUTO_INCREMENT,
idMantenimiento_FK INT NOT NULL,
FOREIGN KEY (idMantenimiento_FK) REFERENCES mantenimientos (idMantenimiento),
carnet_FK4 INT NOT NULL,
FOREIGN KEY (carnet_FK4) REFERENCES usuarios (carnet),
refacciones VARCHAR (500) NOT NULL,
PRIMARY KEY (idRefacciones)
);

SELECT idActivo, nombre, estado 
FROM inventario INNER JOIN prestamo ON (inventario.idActivo = prestamo.idActivo_FK) 
WHERE estado = 'En préstamo' OR estado = 'No entregó'

SELECT COUNT(*)
FROM inventario INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2) 
WHERE calidad_nueva = 'Sin revisar'

SELECT COUNT(*)
FROM inventario INNER JOIN prestamo ON (inventario.idActivo = prestamo.idActivo_FK) INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2)
WHERE calidad_nueva = 'Sin revisar' OR estado = 'En préstamo' OR estado = 'No entregó'

SELECT COUNT(*)
FROM inventario 
WHERE NOT EXISTS (SELECT idActivo, nombre, estado 
FROM inventario INNER JOIN prestamo ON (inventario.idActivo = prestamo.idActivo_FK) 
WHERE estado = 'En préstamo' OR estado = 'No entregó') AND NOT EXISTS (SELECT idActivo, nombre
FROM inventario INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2) 
WHERE calidad_nueva = 'Sin revisar')

SELECT (SELECT COUNT(*)
FROM inventario INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2) 
WHERE calidad_nueva = 'Sin revisar') AS Prestamo, (SELECT COUNT(*)
FROM inventario INNER JOIN prestamo ON (inventario.idActivo = prestamo.idActivo_FK) INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2)
WHERE calidad_nueva = 'Sin revisar' OR estado = 'En préstamo' OR estado = 'No entregó') AS Mantenimiento, (SELECT COUNT(*)
FROM inventario 
WHERE NOT EXISTS (SELECT idActivo, nombre, estado 
FROM inventario INNER JOIN prestamo ON (inventario.idActivo = prestamo.idActivo_FK) 
WHERE estado = 'En préstamo' OR estado = 'No entregó') AND NOT EXISTS (SELECT idActivo, nombre
FROM inventario INNER JOIN mantenimientos ON (inventario.idActivo = mantenimientos.idActivo_FK2) 
WHERE calidad_nueva = 'Sin revisar')) AS Disponibles