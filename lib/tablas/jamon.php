<?php

class Jamon extends Tabla
{
    const TABLA = 'jamones';

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
}