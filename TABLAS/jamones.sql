CREATE TABLE JAMONES (
    id              INT AUTO_INCREMENT PRIMARY KEY
    ,lote           INT NOT NULL

    ,tipo           NOT NULL /*ARRAY EN jamon.php*/
    ,pureza         NOT NULL /*ARRAY EN jamon.php*/
    ,porcentaje     INT /*ARRAY EN jamon.php*/
    ,anotaciones    VARCHAR(255)

    ,peso    DECIMAL(10, 3) NOT NULL
    ,marca   VARCHAR(100)

    ,fecha_caducidad     DATE
    ,precio_de_compra    DECIMAL(10, 2)
    ,precio_de_venta     DECIMAL(10, 2)

    ,ip_alta            VARCHAR(15)
    ,fecha_alta         TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    ,ip_ult_mod         VARCHAR(15)
    ,fecha_ult_mod      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);