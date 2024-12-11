<?php



    class Jamon extends Tabla
    {
        const TABLA = 'jamones';

        const TIPOS = ['PA' => 'Paleta', 'JA' => 'Jamón'];
        const PUREZAS = [
            'IBDO' => 'IBÉRICO DE BELLOTA CON DO',
            'IB' => 'IBÉRICO DE BELLOTA',
            'CC' => 'CEBO DE CAMPO', 'CE' => 'CEBO',
        ];
        const PORCENTAJES = [
            '100' => '100%',
            '75' => '75%',
            '50' => '50%',
        ];        
        

        function __construct()
        {
            parent::__construct(self::TABLA);

        }



        function existeJamon($lote, $tipo, $pureza, $porcentaje, $peso, $marca, $id = '')
        {
            $opt = [];
            
            $opt['select']['id']        = '';
            $opt['where']['lote']       = $lote;
            $opt['where']['tipo']       = $tipo;
            $opt['where']['pureza']     = $pureza;
            $opt['where']['porcentaje'] = $porcentaje;
            $opt['where']['peso']       = $peso;
            $opt['where']['marca']      = $marca;

            if (!empty($id)) {
                $opt['notwhere']['id'] = $id;
            }
            
            $resultado = $this->seleccionar($opt);

            return $resultado->num_rows;
        }

    }