<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$fecha_ultima_actualizacion = 'Fecha de última actualizacón: 11 de julio de 2016 ';
//    pr($tipo_msg);
$colapso_div_ejercicio_profesional = 'collapse in';
//        $colapso_div_ejercicio_profesional = 'collapse';
//        pr($datos_tabla_actividades_docente);
//        pr($actividades_docente_objet);
?>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/validacion_censo_profesores/becas_y_comisiones.js"></script>

<!-- Inicio informacion personal -->
<?php echo form_open('', array('id' => 'form_becas')); ?>

<div class="list-group">

    <div class="list-group-item" style='display:none'>
        <div class='row' >
            <div class="row" id='div_error'>
                <div class="col-md-10 col-sm-10 col-xs-10">
                    <div id='mensaje_error_div' class='alert'>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span id='mensaje_error'></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="list-group-item">
        <ul id="tabList" class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#becas_tab">
                    <strong>
                        <?php echo $string_values['tabs_becas']; ?>
                    </strong>
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#comisiones_tab">
                    <strong>
                        <?php echo $string_values['tabs_comisiones']; ?>
                    </strong>
                </a>
            </li>
        </ul>
        <div id = 'tab_content_becas_comisiones' class='tab-content col-md-12'>

            <div id = 'becas_tab' class='tab-pane fade in active'>
                <div id='div_cuerpo_becas' class="panel-body">
                    <!--Datos de becas laborales-->
                    <?php
                    if (isset($cuerpo_becas)) {
                        echo $cuerpo_becas;
                    }
                    ?>

                </div>
            </div><!--Termina primer tab becas-->

            <div id = 'comisiones_tab' class='tab-pane fade'>
                <div id='div_cuerpo_comisiones' class="panel-body">
                    <!--Datos de comisiones laborales-->
                    <?php
                    if (isset($cuerpo_comisiones)) {
                        echo $cuerpo_comisiones;
                    }
                    ?>
                </div>
            </div><!--Termina segundo tab comisiones-->

        </div>
    </div>
</div>

<script type="text/template" id="template_row_nueva_beca">

</script>
<script type="text/template" id="template_row_nueva_comision">

</script>


<?php echo form_close(); ?>
  