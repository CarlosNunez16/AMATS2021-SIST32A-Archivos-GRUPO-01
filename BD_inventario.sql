CREATE DATABASE inventario;
USE inventario;

CREATE TABLE usuario (
carnet INT NOT NULL,
nombres VARCHAR (100) NOT NULL,
apellidos VARCHAR (100) NOT NULL,
direccion VARCHAR (100) NOT NULL,
contraseña VARCHAR (75) NOT NULL,
tipo_usuario VARCHAR (50) NOT NULL,
carrera VARCHAR (50) NOT NULL,
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
FOREIGN KEY (carnet_FK) REFERENCES usuario (carnet),
ubicacion VARCHAR (100) NOT NULL,
fecha_asignacion VARCHAR (100) NOT NULL,
calidad VARCHAR (100) NOT NULL,
PRIMARY KEY (idActivo)
);

CREATE TABLE prestamo (
idPrestamo INT NOT NULL AUTO_INCREMENT,
carnet_FK2 INT NOT NULL,
FOREIGN KEY (carnet_FK2) REFERENCES usuario (carnet),
idActivo_FK INT NOT NULL,
FOREIGN KEY (idActivo_FK) REFERENCES inventario (idActivo),
fecha_prestamo VARCHAR (100) NOT NULL,
hora_pretamo VARCHAR (100) NOT NULL,
fecha_entrega VARCHAR (100) NOT NULL,
hora_entrega VARCHAR (100) NOT NULL,
estado VARCHAR (100) NOT NULL,
calidad_entrega VARCHAR (100) NOT NULL,
PRIMARY KEY (idPrestamo)
);

CREATE TABLE reportes (
idDanos INT NOT NULL AUTO_INCREMENT,
idPrestamo_FK INT NOT NULL,
FOREIGN KEY (idPrestamo_FK) REFERENCES prestamo (idPrestamo),
fecha VARCHAR (100) NOT NULL,
detalles VARCHAR (100) NOT NULL,
PRIMARY KEY (idDanos)
);

CREATE TABLE mantenimientos (
idMantenimiento INT NOT NULL AUTO_INCREMENT,
idActivo_FK2 INT NOT NULL,
FOREIGN KEY (idActivo_FK2) REFERENCES inventario (idActivo),
fecha VARCHAR (100) NOT NULL,
detalles VARCHAR (100) NOT NULL,
carnet_FK3 INT NOT NULL,
FOREIGN KEY (carnet_FK3) REFERENCES usuario (carnet),
total VARCHAR (100) NOT NULL,
justificacion VARCHAR (100) NOT NULL,
tiempò VARCHAR (100) NOT NULL,
proximo_mantenimiento VARCHAR (100) NOT NULL,
calidad_nueva VARCHAR (100) NOT NULL,
PRIMARY KEY (idMantenimiento)
);

CREATE TABLE refacciones (
idRefacciones INT NOT NULL AUTO_INCREMENT,
idMantenimiento_FK INT NOT NULL,
FOREIGN KEY (idMantenimiento_FK) REFERENCES mantenimientos (idMantenimiento),
carnet_FK4 INT NOT NULL,
FOREIGN KEY (carnet_FK4) REFERENCES usuario (carnet),
nombre VARCHAR (100) NOT NULL,
marca VARCHAR (100) NOT NULL,
modelo VARCHAR (100) NOT NULL,
color VARCHAR (100) NOT NULL,
numero_serie VARCHAR (100) NOT NULL,
nueva_ubicacion VARCHAR (100) NOT NULL, 
PRIMARY KEY (idRefacciones)
);
SELECT * FROM usuario
INSERT INTO usuario (carnet,nombres,apellidos, direccion, contraseña, tipo_usuario, carrera, cantidad_reportes) VALUES (128820, 'Carlos', 'Pineda', 'Santa Ana', 'admin', 'administrador', 'Sistemas', 0);