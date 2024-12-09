<?php

class Jamon extends Tabla
{
    const TABLA = 'jamones';

    const TIPO       = ['PA' => 'Paleta', 'JA' => 'Jamón'];
    const PUREZA     = ['DO' => 'Ibérico de Bellota con Denominación de Origen', 
    'IBE' => 'Ibérico de bellota', 'CEC' => 'Cebo de campo', 'CE' => 'Cebo'];
    const PORCENTAJE = ['100%' => 100, '75%' => 75, '50%' => 50];

    function __construct()
    {
        parent::__construct(self::TABLA);
    }

    function listaJamones()
    {
        $lista_jamones = [];

        $opt = [];

        // Seleccionar las columnas relevantes de la tabla JAMONES
        $opt['select']['id']               = '';
        $opt['select']['lote']             = '';
        $opt['select']['fecha_caducidad']  = '';
        $opt['select']['descripcion']      = '';
        $opt['select']['tipo']             = '';
        $opt['select']['pureza']           = '';
        $opt['select']['porcentaje']       = '';
        $opt['select']['peso']             = '';
        $opt['select']['marca']            = '';
        $opt['select']['precio_de_compra'] = '';
        $opt['select']['precio_de_venta']  = '';

        $resultado = $this->seleccionar($opt);

        if ($resultado->num_rows > 0) 
        {
            while ($fila = $resultado->fetch_assoc()) 
            {
                // Crear la clave única usando el ID (clave primaria)
                $clave = $fila['id'];
                
                $descripcion = "[{$fila['lote']}] {$fila['marca']} - {$fila['tipo']} ({$fila['pureza']})";
                
                $lista_jamones[$clave] = $descripcion;
            }
        }

        return $lista_jamones;
    }

    function existeJamon($lote, $fecha_caducidad, $descripcion, $tipo, $pureza, $porcentaje, $peso, $marca, $precio_de_compra, $precio_de_venta, $id = '')
    {
        $opt = [];
        
        $opt['select']['lote']            = '';
        $opt['where']['lote']             = $lote;
        $opt['where']['fecha_caducidad']  = $fecha_caducidad;
        $opt['where']['descripcion']      = $descripcion;
        $opt['where']['tipo']             = $tipo;
        $opt['where']['pureza']           = $pureza;
        $opt['where']['porcentaje']       = $porcentaje;
        $opt['where']['peso']             = $peso;
        $opt['where']['marca']            = $marca;
        $opt['where']['precio_de_compra'] = $precio_de_compra;
        $opt['where']['precio_de_venta']  = $precio_de_venta;

        if(!empty($id))
            $opt['notwhere']['id'] = $id;
    
        $resultado = $this->seleccionar($opt);

        return $resultado->num_rows;
    }
}