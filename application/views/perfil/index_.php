<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->lang->load('interface', 'spanish');
$string_values = $this->lang->line('interface');
//pr($array_menu);
?>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/perfil/informacionGeneral.js"></script>

<script>
    var array_menu_perfil = new Array(15);
    var hrutes = new Object();//Objeto que almacena las rutas del controlador 
</script>

<div class="row" id="contenedor_formulario">
    <div class="col-md-3">
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-green">
              <h2 class="widget-user-username"><span class="glyphicon glyphicon-info-sign"></span> Mi perfil</h2>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <?php
                    foreach ($array_menu as $value) {
                        $pos = strpos($value['ruta'], ':');
                        if ($pos > 0) {
                            $separa = explode(":", $value['ruta']);
                            $val = $separa[0];
                            ?>
                            <script >
                                /*Guarda los datos de configuración para el uso de ajax en javascript*/
                                hrutes['<?php echo $val; ?>'] = '<?php echo $value['ruta_padre'] . ":" . $value['ruta']; ?>';
                            </script>
                            <?php
                        } else {
                            $val = $value['ruta'];
                            $separa = array();
                        }
                        ?>
                        <li>
                            <a data-toggle="tab" href="#<?php echo $val ?>" >
                                <?php echo $value['nombre_modulo']; ?>
                            </a>
                        </li>
                    <?php } ?>
              </ul>
            </div>
          </div>
        </div>
    
    <div class="col col-md-9">
        <div class="panel">
            <div class="panel-body">
                 <?php
                    foreach ($array_menu as $value) {
                        $pos = strpos($value['ruta'], ':');
                        if ($pos > 0) {
                            $separa = explode(":", $value['ruta']);
//                            $val = str_replace($array_quitar, "", $separa [0]);
                            $val = $separa[0];
                        } else {
//                            $val = str_replace($array_quitar, "", $value['ruta']);
                            $val = $value['ruta'];
                        }
                        ?>
                        <div id = '<?php echo $val; ?>' class = 'tab-pane fade'>
                            <div class ="row">
                                <?php
//                                $busca_cadena = strpos($value['ruta'], 'seccion'); //Busca si el metodo a invocar es un metodo, con palabra clave "seccion"
//                                pr($value['ruta'] . ' ' . $busca_cadena);
//                                $busca_cadena = ($busca_cadena === 0) ? 1 : $busca_cadena;

                                if (strpos($value['ruta'], 'seccion') >= 0) {//Quitar, cuando se quiten todos los seccion
                                    $busca_cadena = strpos($value['ruta'], 'seccion');
                                } else if (strpos($value['ruta'], 'ajax') >= 0) {
                                    $busca_cadena = strpos($value['ruta'], 'ajax');
                                } else {
                                    $busca_cadena = 1;
                                }

                                $busca_cadena = strpos($value['ruta'], 'ajax'); //Busca si el metodo a invocar es un ajax
                                $busca_cadena = ($busca_cadena >= 0) ? 1 : $busca_cadena;
//                                    pr('Invoca ajax ' . $busca_cadena);
                                if (!$busca_cadena) {//Si no existe un ajax, llama a una vista, es importante que exista, para que muestré la pantalla correctamente
                                    $this->load->view($value['ruta_padre'] . "/" . $value['ruta']);
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
