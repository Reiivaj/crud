<?php

    class Literal
    {
        //instancia única
        private static $instance;


        public function __construct($idioma='ES')
        {

            switch($idioma)
            {
                case 'ES':
                    $this->lit = [
                         'lote'               => 'Lote'
                       , 'descripcion'        => 'Descripción'
                       , 'fecha_caducidad'    => 'Fecha de caducidad'
                       , 'peso'               => 'Peso'
                       , 'precio_de_compra'   => 'Precio de compra'
                       , 'precio_de_venta'    => 'Precio de venta'

                       , 'tipo'               => 'Tipo'
                       , 'pureza'             => 'Pureza'
                       , 'porcentaje'         => 'Porcentaje'
                       , 'marca'              => 'Marca'
                       

                       , 'error_gen'          => 'El campo es inválido'

                       , 'enviar'             => 'Enviar'
                       , 'nuevo'              => 'Nuevo'
                       , 'editar'             => 'Editar'
                       , 'lista_jamones'      => 'Listado de jamones'

                       , 'mensaje_duplicados' => 'Hay un registro duplicado en BBDD'
                       , 'mensaje_exito'      => 'Operación realizada con éxito'
 
                    ];

                break;
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
    }