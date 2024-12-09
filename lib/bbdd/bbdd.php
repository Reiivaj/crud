<?php

    class BBDD
    {
        private static $instance;

        private const SERVIDOR = 'localhost';
        private const USUARIO  = 'cruz';
        private const PASSWORD = 'csas1234.';
        private const BBDD     = 'JAMONES_CRUZ';

        private function __construct()
        {      
            $this->conexion = new mysqli(self::SERVIDOR, self::USUARIO, self::PASSWORD, self::BBDD);
        
            if ($this->conexion->connect_error) 
            {
                die("Conexión fallida: " . $this->conexion->connect_error);
            }
        
        }

        static public function getInstance()
        {

            if (empty(self::$instance))
            {
                self::$instance = new self();
            }

            return self::$instance;
        }

        function __desctruct()
        {
            self::$instance->conexion->close();
        }


        static public function query($query)
        {
            self::getInstance();

            return self::$instance->conexion->query($query);
        }
    }