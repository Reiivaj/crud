CREATE TABLE JAMONES (
    id              INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    lote            INT NOT NULL,
    fecha_caducidad DATE,
    descripcion     VARCHAR(255),

    tipo        NOT NULL,
    pureza      NOT NULL,
    porcentaje  DECIMAL(5, 2) NOT NULL,

    peso    DECIMAL(5, 3) NOT NULL,
    marca   VARCHAR(100),

    precio_de_compra    DECIMAL(10, 2),
    precio_de_venta     DECIMAL(10, 2),
);