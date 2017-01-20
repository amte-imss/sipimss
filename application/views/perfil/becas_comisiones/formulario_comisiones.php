<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($informacion_comisiones)) {
    extract($informacion_comisiones, EXTR_OVERWRITE); //EXTR_IF_EXISTS; EXTR_PREFIX_ALL; EXTR_OVERWRITE; EXTR_PREFIX_INVALID
}
?>

<script type='text/javascript'>
    $(function () {
        $('#datetimepicker1').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY-MM-DD',
            locale: 'es',
            useCurrent: false,
            minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
            maxDate: 'now'
        });
        $('#datetimepicker2').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            },
            format: 'YYYY-MM-DD',
            locale: 'es',
            useCurrent: false,
            minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
            maxDate: 'now'
        });

        $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
    });
     $('.btn_subir_comprobante').click(function () {
        cargar_archivo($(this).attr('data-key'), "#form_comisiones_laborales");
    });
</script>
<?php echo form_open_multipart('', array('id' => 'form_comisiones_laborales')); ?>
<div class="list-group">
    <div class='row'>
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <label for='lbl_tipo_comision' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_tipo_comision']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user"> </span>
                </span>
                <?php
                echo $this->form_complete->create_element(array('id' => 'ctipo_comision', 'type' => 'dropdown',
                    'options' => $ctipo_comision,
                    'first' => null,
                    'value' => (isset($tipo_comision_cve)) ? $tipo_comision_cve : '',
                    'attributes' => array('class' => 'form-control',
                        'placeholder' => $string_values['lbl_tipo_comision'],
                        'data-toggle' => 'tooltip', 'data-placement' => 'top',
                        'title' => $string_values['lbl_tipo_comision'])));
                ?>
            </div>
            <?php echo form_error_format('ctipo_comision'); ?>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class='row'>
        <div class='col-sm-12 text-center' id="fecha_inicio">
            <label for='lbl_comision_periodo' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_comision_periodo']; ?>
            </label>
        </div>
    </div>
    <br>
    <div class='row'>
        <div class='col-sm-6' id="fecha_inicio">
            <div class="form-group">
                <div class="input-group date" id="datetimepicker1" >
                    <?php
                    echo $this->form_complete->create_element(
                            array('id' => 'fecha_inicio', 'type' => 'text',
                                'value' => (isset($fecha_inicio)) ? $fecha_inicio : '',
                                'attributes' => array(
                                    'class' => 'form-control',
                                    'placeholder' => $string_values['placeholder_formato_fecha'],
                                    'data-toggle' => 'tooltip',
                                    'title' => $string_values['lbl_comision_fecha_inicio'],
                                )
                            )
                    );
                    ?>
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
            </div>
            <?php echo form_error_format('fecha_inicio'); ?>

        </div>
        <div class='col-sm-6 ' id="fecha_fin">
            <div class="form-group">
                <div class='input-group date' id='datetimepicker2'>
                    <?php
                    echo $this->form_complete->create_element(
                            array('id' => 'fecha_fin', 'type' => 'text',
                                'value' => (isset($fecha_fin)) ? $fecha_fin : '',
                                'attributes' => array(
                                    'class' => 'form-control',
                                    'placeholder' => $string_values['placeholder_formato_fecha'],
                                    'data-toggle' => 'tooltip',
                                    'title' => $string_values['lbl_comision_fecha_fin'],
                                )
                            )
                    );
                    ?>
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
            </div>
            <?php echo form_error_format('fecha_fin'); ?>
        </div>
    </div>
    <?php
    //Formulario de cargar comprobante
    if (isset($formulario_carga_archivo)) {
    echo $formulario_carga_archivo;
    }
    ?>
</div>
<?php echo form_close(); ?>