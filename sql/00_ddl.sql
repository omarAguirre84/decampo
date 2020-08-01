CREATE DATABASE IF NOT EXISTS decampo;
USE decampo;

CREATE TABLE IF NOT EXISTS productos(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(30),
    precio_pesos DOUBLE
);


