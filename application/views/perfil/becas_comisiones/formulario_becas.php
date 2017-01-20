<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($informacion_becas)) {
    extract($informacion_becas, EXTR_OVERWRITE); //EXTR_IF_EXISTS; EXTR_PREFIX_ALL; EXTR_OVERWRITE; EXTR_PREFIX_INVALID
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
        cargar_archivo($(this).attr('data-key'), "#form_becas_laborales");
    });
</script>
<?php echo form_open_multipart('', array('id' => 'form_becas_laborales')); ?>
<div class="list-group">
    <div class='row'>
        <div class='col-sm-12 text-center' id="fecha_inicio">
            <label for='lbl_beca_periodo' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_beca_periodo']; ?>
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
                                    'title' => $string_values['lbl_beca_fecha_inicio'],
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
                                    'title' => $string_values['lbl_beca_fecha_fin'],
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
    <div class='row'>
        <div class="col-md-6">
            <label for='lbl_beca_clase' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_beca_clase']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user"> </span>
                </span>
                <?php
                echo $this->form_complete->create_element(array('id' => 'cclase_beca', 'type' => 'dropdown',
                    'options' => $cclase_beca,
                    'first' => array('' => $string_values['drop_beca_clase']),
                    'value' => (isset($clase_beca_cve)) ? $clase_beca_cve : '',
                    'attributes' => array('class' => 'form-control',
                        'placeholder' => $string_values['lbl_beca_clase'],
                        'data-toggle' => 'tooltip', 'data-placement' => 'top',
                        'title' => $string_values['lbl_beca_clase'])));
                ?>
            </div>
            <?php echo form_error_format('cclase_beca'); ?>
        </div>
        <div class="col-md-6">
            <label for='lbl_beca_motivo' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_beca_motivo']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user"> </span>
                </span>
                <?php
                echo $this->form_complete->create_element(array('id' => 'cmotivo_becado', 'type' => 'dropdown',
                    'options' => $cmotivo_becado,
                    'first' => array('' => $string_values['drop_beca_motivo']),
                    'value' => (isset($motivo_beca_cve)) ? $motivo_beca_cve : '',
                    'attributes' => array('class' => 'form-control',
                        'placeholder' => $string_values['lbl_beca_motivo'],
                        'data-toggle' => 'tooltip', 'data-placement' => 'top',
                        'title' => $string_values['lbl_beca_motivo'])));
                ?>
            </div>
            <?php echo form_error_format('cmotivo_becado'); ?>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-6">
            <label for='lbl_beca_interrumpida' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_beca_interrumpida']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user"> </span>
                </span>
                <?php
                echo $this->form_complete->create_element(array('id' => 'cbeca_interrumpida', 'type' => 'dropdown',
                    'options' => $cbeca_interrumpida,
                    'first' => array('' => $string_values['drop_beca_interrumpida']),
                    'value' => (isset($beca_interrumpida_cve)) ? $beca_interrumpida_cve : '',
                    'attributes' => array('class' => 'form-control',
                        'placeholder' => $string_values['lbl_beca_interrumpida'],
                        'data-toggle' => 'tooltip', 'data-placement' => 'top',
                        'title' => $string_values['lbl_beca_interrumpida'])));
                ?>
            </div>
            <?php echo form_error_format('cbeca_interrumpida'); ?>
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