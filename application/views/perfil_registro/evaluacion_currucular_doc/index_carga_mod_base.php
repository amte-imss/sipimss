<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->lang->load('interface', 'spanish');
$string_values = $this->lang->line('interface');
//pr($array_menu);
?>
<?php echo css("style-sipimss.css"); ?>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/evaluacion_curricular/index_eva_curricular.js"></script>
<script>
    $('.botonF1').hover(function () {
        $('.btn').addClass('animacionVer');
    })
    $('.contenedor').mouseleave(function () {
        $('.btn').removeClass('animacionVer');
    })
</script>

<div class="panel-group" id="accordion">
    <?php
    foreach ($array_menu as $key_tab => $value_tab) {
        ?>
        <script >
            /*Guarda los datos de configuración para el uso de ajax en javascript*/
            hrutes['<?php echo $value_tab['ruta']; ?>'] = '<?php echo $value_tab['ruta_padre']; ?>';
        </script>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $value_tab['ruta'] ?>">
                        <span class="glyphicon glyphicon-th"></span>
                        <?php echo $value_tab['nombre_modulo'] ?>
                    </a>
                </h4>
            </div>
            <div id="<?php echo $value_tab['ruta'] ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                <div id="cuerpo_<?php echo $value_tab['ruta'] ?>" class="box-body">
                    <?php echo $value_tab['ruta'] ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 contenedor" >
        <span id="pie"  onclick="funcion_cerrar_validacion_empleado(this)">
            <a class="botonF1" data-toggle='tab' href='#select_buscador_validar_evaluacion'>><?php // echo $string_values['lbl_validar_empleado'];                ?></a>
        </span>
    </div>
</div>