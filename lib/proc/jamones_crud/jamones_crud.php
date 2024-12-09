<?php

class JamonesCRUD extends ProgramaBase
{
    const LIMITE_SCROLL = 5;

    function __construct()
    {
        $this->jamon = new Jamon();
        parent::__construct($this->jamon);
    }

    function inicializar()
    {
        $paso               = new Hidden('paso');
        $paso->value        = 1;

        $oper               = new Hidden('oper');
        $id                 = new Hidden('id');

        $lote               = new Input('lote'           , ['placeholder' => 'Número de lote...'      , 'validar' => True, 'ereg' => EREG_NUMERO_OBLIGATORIO]);
        $fecha_caducidad    = new Input('fecha_caducidad', ['placeholder' => 'Fecha de caducidad...' , 'validar' => True, 'ereg' => EREG_FECHA_OBLIGATORIO]);
        $descripcion        = new Textarea('descripcion'   , ['placeholder' => 'Descripción del jamón...', 'validar' => True]);
        $tipo               = new Select('tipo', ['options' => Jamon::TIPO, 'placeholder' => 'Seleccione el tipo...', 'validar' => True]);
        $pureza             = new Select('pureza', ['options' => Jamon::PUREZA, 'placeholder' => 'Seleccione la pureza...', 'validar' => True]);
        $porcentaje         = new Select('porcentaje', ['options' => Jamon::PORCENTAJE, 'placeholder' => 'Seleccione el porcentaje...', 'validar' => True]);
        $peso               = new Input('peso'            , ['placeholder' => 'Peso del jamón...'         , 'validar' => True, 'ereg' => EREG_NUMERO_100_OBLIGATORIO]);
        $marca              = new Input('marca'           , ['placeholder' => 'Marca del jamón...'        , 'validar' => True, 'ereg' => EREG_TEXTO_100_OBLIGATORIO]);
        $precio_de_compra   = new Input('precio_de_compra' , ['placeholder' => 'Precio de compra...'    , 'validar' => True, 'ereg' => EREG_NUMERO_OBLIGATORIO]);
        $precio_de_venta    = new Input('precio_de_venta'  , ['placeholder' => 'Precio de venta...'     , 'validar' => True, 'ereg' => EREG_NUMERO_OBLIGATORIO]);

        $this->form->cargar($paso);
        $this->form->cargar($oper);
        $this->form->cargar($id);
        $this->form->cargar($lote);
        $this->form->cargar($fecha_caducidad);
        $this->form->cargar($descripcion);
        $this->form->cargar($tipo);
        $this->form->cargar($pureza);
        $this->form->cargar($porcentaje);
        $this->form->cargar($peso);
        $this->form->cargar($marca);
        $this->form->cargar($precio_de_compra);
        $this->form->cargar($precio_de_venta);
    }

    function existe($id = '')
    {
        if (empty($this->form->val['lote']) ||
            empty($this->form->val['fecha_caducidad']) ||
            empty($this->form->val['descripcion']) ||
            empty($this->form->val['tipo']) ||
            empty($this->form->val['pureza']) ||
            empty($this->form->val['porcentaje']) ||
            empty($this->form->val['peso']) ||
            empty($this->form->val['marca']) ||
            empty($this->form->val['precio_de_compra']) ||
            empty($this->form->val['precio_de_venta'])
        ) {
            return false;
        }

        return $this->jamon->existeJamon(
            $this->form->val['lote'],
            $this->form->val['fecha_caducidad'],
            $this->form->val['descripcion'],
            $this->form->val['tipo'],
            $this->form->val['pureza'],
            $this->form->val['porcentaje'],
            $this->form->val['peso'],
            $this->form->val['marca'],
            $this->form->val['precio_de_compra'],
            $this->form->val['precio_de_venta'],
            $id
        ) > 0;
    }

    function recuperar()
    {
        $this->jamon->recuperar($this->form->val['id']);

        $this->form->elementos['lote']->value               = $this->jamon->lote;
        $this->form->elementos['fecha_caducidad']->value    = $this->jamon->fecha_caducidad;
        $this->form->elementos['descripcion']->value        = $this->jamon->descripcion;
        $this->form->elementos['tipo']->value               = $this->jamon->tipo;
        $this->form->elementos['pureza']->value             = $this->jamon->pureza;
        $this->form->elementos['porcentaje']->value         = $this->jamon->porcentaje;
        $this->form->elementos['peso']->value               = $this->jamon->peso;
        $this->form->elementos['marca']->value              = $this->jamon->marca;
        $this->form->elementos['precio_de_compra']->value   = $this->jamon->precio_de_compra;
        $this->form->elementos['precio_de_venta']->value    = $this->jamon->precio_de_venta;
    }

    function resultados_busqueda()
    {
        $listado_jamones = '
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Lote</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Pureza</th>
                    <th scope="col">Porcentaje</th>
                    <th scope="col">Peso</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Precio Compra</th>
                    <th scope="col">Precio Venta</th>
                </tr>
            </thead>
            <tbody>';

        $limite = JamonesCRUD::LIMITE_SCROLL;
        $pagina = $this->form->val['pagina'];
        $offset = $pagina * $limite;

        $opt = [];
        $opt['orderby']['fecha_ult_mod'] = 'DESC';
        $opt['offset'] = $offset;
        $opt['limit']  = $limite;

        $resultado = $this->jamon->seleccionar($opt);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $listado_jamones .= "
                    <tr>
                        <th scope=\"row\">
                            ". enlace("/{$this->seccion}/actualizar/{$fila['id']}", 'Actualizar',['class' => 'btn btn-primary']) ."
                            ". enlace("#", 'Eliminar', ['class' => 'btn btn-danger', 'onclick' => "if(confirm('Cuidado, estás tratando de eliminar el jamón: {$fila['lote']}')) location.href = '/jamones/eliminar/{$fila['id']}';"]) ."
                        </th>
                        <td>{$fila['lote']}</td>
                        <td>{$fila['descripcion']}</td>
                        <td>" . Jamon::TIPO[$fila['tipo']] . "</td>
                        <td>" . Jamon::PUREZA[$fila['pureza']] . "</td>
                        <td>" . Jamon::PORCENTAJE[$fila['porcentaje']] . "</td>
                        <td>{$fila['peso']}</td>
                        <td>{$fila['marca']}</td>
                        <td>{$fila['precio_de_compra']}</td>
                        <td>{$fila['precio_de_venta']}</td>
                    </tr>";
            }

            if ($resultado->num_rows == JamonesCRUD::LIMITE_SCROLL) {
                $siguiente = '<li class="page-item">' . enlace("/{$this->seccion}/pag/" . ($pagina + 1), 'Siguiente', ['class' => 'page-link']) . '</li>';
            }
        } else {
            $listado_jamones = '<tr><td colspan="10">No hay resultados</td></tr>';
        }

        if ($pagina)
            $pagina_anterior = '<li class="page-item">' . enlace("/{$this->seccion}/pag/" . ($pagina - 1), 'Anterior', ['class' => 'page-link']) . '</li>';

        $listado_jamones .= '
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    ' . $pagina_anterior . '
                    ' . $siguiente . '
                </ul>
            </nav>

            <div class="alta">' . enlace("/{$this->seccion}/alta/", 'Alta de jamón', ['class' => 'btn btn-success']) . '</div>
        ';

        return $listado_jamones;
    }
}