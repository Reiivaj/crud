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
            $paso        = new Hidden('paso'); 
            $paso->value = 1;

            $oper        = new Hidden('oper'); 
            $id          = new Hidden('id');        

            $lote        = new Input   ('lote'        , ['placeholder' => 'Número de lote...', 'validar' => True, 'ereg' => EREG_NUMERICO_OBLIGATORIO ]);
            $tipo        = new Select  ('tipo'        , Jamon::TIPOS,    ['validar' => True ]);
            $pureza      = new Select  ('pureza'      , Jamon::PUREZAS,  ['validar' => True ]);
            $porcentaje  = new Select  ('porcentaje'  , Jamon::PORCENTAJES, ['validar' => True ]);
            $peso        = new Input   ('peso'        , ['placeholder' => 'Peso en kg...',    'validar' => True, 'ereg' => EREG_DECIMAL_OBLIGATORIO ]);
            $marca       = new Input   ('marca'       , ['placeholder' => 'Marca del jamón...', 'validar' => True, 'ereg' => EREG_TEXTO_100_OBLIGATORIO ]);
            $anotaciones = new Textarea('anotaciones' , ['placeholder' => 'Anotaciones adicionales...', 'validar' => False ]);

            $this->form->cargar($paso);
            $this->form->cargar($oper);
            $this->form->cargar($id);
            $this->form->cargar($lote);
            $this->form->cargar($tipo);
            $this->form->cargar($pureza);
            $this->form->cargar($porcentaje);
            $this->form->cargar($peso);
            $this->form->cargar($marca);
            $this->form->cargar($anotaciones);
        }

        function existe($id = '')
        {
            $cantidad = 0;

            if (   !empty($this->form->val['lote']) 
                && !empty($this->form->val['tipo'])
                && !empty($this->form->val['pureza'])
                && !empty($this->form->val['porcentaje'])
                && !empty($this->form->val['peso'])
                && !empty($this->form->val['marca'])
            ) {   
                $cantidad = $this->jamon->existeJamon(
                    $this->form->val['lote'],
                    $this->form->val['tipo'],
                    $this->form->val['pureza'],
                    $this->form->val['porcentaje'],
                    $this->form->val['peso'],
                    $this->form->val['marca'],
                    $this->form->val['id']
                );
            }

            return $cantidad;
        }


        function recuperar()
        {
            $this->jamon->recuperar($this->form->val['id']);

            $this->form->elementos['lote']->value        = $this->jamon->lote;
            $this->form->elementos['tipo']->value        = $this->jamon->tipo;
            $this->form->elementos['pureza']->value      = $this->jamon->pureza;
            $this->form->elementos['porcentaje']->value  = $this->jamon->porcentaje;
            $this->form->elementos['peso']->value        = $this->jamon->peso;
            $this->form->elementos['marca']->value       = $this->jamon->marca;
            $this->form->elementos['anotaciones']->value = $this->jamon->anotaciones;
        }

        function resultados_busqueda()
        {
            $listado_jamones = '
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Lote</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Pureza</th>
                        <th scope="col">Porcentaje</th>
                        <th scope="col">Peso</th>
                        <th scope="col">Marca</th>
                    </tr>
                </thead>
                <tbody>
            ';

            $limite = JamonCrud::LIMITE_SCROLL;

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
                                " . enlace("/{$this->seccion}/actualizar/{$fila['id']}", 'Actualizar', ['class' => 'btn btn-primary']) . "
                                " . enlace("#", 'Eliminar', ['class' => 'btn btn-danger', 'onclick' => "if(confirm('Cuidado, estás tratando de eliminar el jamón del lote: {$fila['lote']}')) location.href = '/jamon/eliminar/{$fila['id']}';"]) . "
                            </th>
                            <td>{$fila['lote']}</td>
                            <td>" . Jamon::TIPOS[$fila['tipo']] . "</td>
                            <td>" . Jamon::PUREZAS[$fila['pureza']] . "</td>
                            <td>" . Jamon::PORCENTAJES[$fila['porcentaje']] . "</td>
                            <td>{$fila['peso']} kg</td>
                            <td>{$fila['marca']}</td>
                        </tr>
                    ";
                }

                if ($resultado->num_rows == JamonCrud::LIMITE_SCROLL) {
                    $siguiente = '<li class="page-item">' . enlace("/{$this->seccion}/pag/" . ($pagina + 1), 'Siguiente', ['class' => 'page-link']) . '</li>';
                }
            } else {
                $listado_jamones = '<tr><td colspan="7">No hay resultados</td></tr>';
            }

            if ($pagina) {
                $pagina_anterior = '<li class="page-item">' . enlace("/{$this->seccion}/pag/" . ($pagina - 1), 'Anterior', ['class' => 'page-link']) . '</li>';
            }

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