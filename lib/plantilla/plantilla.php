<?php

    class Plantilla
    {

        static function header($titulo, $opciones = array()){
            $menu = '';
            if(!$opciones['ocultar_menu'])
            {
                $menu = self::menu();
            }

            return "
                <!DOCTYPE html>
                <html lang=\"en\">
                    <head>
                        <meta charset=\"utf-8\"/>
                        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\" />
                        <meta name=\"description\" content=\"\" />
                        <meta name=\"author\" content=\"\" />
                        <title>{$titulo}</title>
                        <link rel=\"icon\" type=\"image/x-icon\" href=\"/assets/favicon.ico\" />
                        <link href=\"https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i\" rel=\"stylesheet\" />
                        <link href=\"https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i\" rel=\"stylesheet\"/>
                        <link href=\"/css/styles.css\" rel=\"stylesheet\" />
                    </head>
                    <body>
                        <header>
                            <h1 class=\"site-heading text-center text-faded d-none d-lg-block\">
                                <span class=\"site-heading-upper text-primary mb-3\">Jamones Iván Cruz</span>
                                <span class=\"site-heading-lower\">Calidad y Tradición</span>
                            </h1>
                        </header>
            " . $menu;
        }

        static function menu()
        {
            return "
                <!-- Navigation-->
                <nav class=\"navbar navbar-expand-lg navbar-dark py-lg-4\" id=\"mainNav\">
                    <div class=\"container\">
                        <a class=\"navbar-brand text-uppercase fw-bold d-lg-none\" href=\"/\">Jamones Iván Cruz</a>
                        <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"><span class=\"navbar-toggler-icon\"></span></button>
                        <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                            <ul class=\"navbar-nav mx-auto\">
                                <li class=\"nav-item px-lg-4\"><a class=\"nav-link text-uppercase\" href=\"/\">Inicio</a></li>
                                <li class=\"nav-item px-lg-4\"><a class=\"nav-link text-uppercase\" href=\"/jamones/\">Jamones</a></li>
                                <li class=\"nav-item px-lg-4\"><a class=\"nav-link text-uppercase\" href=\"/about\">Sobre Nosotros</a></li>
                                <li class=\"nav-item px-lg-4\"><a class=\"nav-link text-uppercase\" href=\"/contact\">Contacto</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            ";
        }

        static function footer()
        {
            return "
                        <section class=\"page-section clearfix\">
                        <div class=\"container\">
                            <div class=\"intro\">
                                <img class=\"intro-img img-fluid mb-3 mb-lg-0 rounded\" src=\"/assets/img/intro.jpg\" alt=\"Jamón ibérico\" />
                                <div class=\"intro-text left-0 text-center bg-faded p-5 rounded\">
                                    <h2 class=\"section-heading mb-4\">
                                        <span class=\"section-heading-upper\">Jamones de Calidad</span>
                                        <span class=\"section-heading-lower\">Sabor Inigualable</span>
                                    </h2>
                                    <p class=\"mb-3\">Cada uno de nuestros jamones es cuidadosamente seleccionado y curado para ofrecerte el mejor sabor y calidad. Una vez que lo pruebes, nuestro jamón se convertirá en una delicia imprescindible en tu mesa - ¡te lo garantizamos!</p>
                                    <div class=\"intro-button mx-auto\"><a class=\"btn btn-primary btn-xl\" href=\"/jamones/\">Ver Nuestros Jamones</a></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class=\"page-section cta\">
                        <div class=\"container\">
                            <div class=\"row\">
                                <div class=\"col-xl-9 mx-auto\">
                                    <div class=\"cta-inner bg-faded text-center rounded\">
                                        <h2 class=\"section-heading mb-4\">
                                            <span class=\"section-heading-upper\">Nuestra Promesa</span>
                                            <span class=\"section-heading-lower\">Para Ti</span>
                                        </h2>
                                        <p class=\"mb-0\">Cuando eliges nuestros jamones, te garantizamos un producto de la más alta calidad, elaborado con los mejores ingredientes y siguiendo métodos tradicionales. Si no estás satisfecho, háganoslo saber y haremos todo lo posible para solucionarlo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class=\"footer text-faded text-center py-5\">
                        <div class=\"container\"><p class=\"m-0 small\">Copyright &copy; Jamones Iván Cruz 2023</p></div>
                    </footer>
                    <!-- Bootstrap core JS-->
                    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js\"></script>
                    <!-- Core theme JS-->
                    <script src=\"/js/scripts.js\"></script>
                </body>
            </html>
            ";
        }

        static function cargarSeccion($seccion)
        {
            $titulo = 'Jamones Iván Cruz';
            if (!empty($seccion))
                $titulo .= ' - '.ucfirst($seccion);

            $salida = Plantilla::header($titulo);

            if (empty($seccion))
                $seccion = 'index';
            

            switch($seccion)
            {
                case 'index':
                    $objeto_crud = new IndexCRUD();  
                break;

                default:
                    $clase_crud = ucfirst($seccion) . 'CRUD';
                    
                    $objeto_crud = new $clase_crud();                    
                break;
            }

            $salida .= $objeto_crud->main();

            $salida .= Plantilla::footer();

            return $salida;

        }
    }