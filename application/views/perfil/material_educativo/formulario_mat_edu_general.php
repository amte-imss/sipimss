<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (isset($info_material_educativo)) {
    extract($info_material_educativo, EXTR_OVERWRITE); //EXTR_IF_EXISTS; EXTR_PREFIX_ALL; EXTR_OVERWRITE; EXTR_PREFIX_INVALID
}
?>

<script type="text/javascript">
    $("#datetimepicker1").datetimepicker({
        format: "YYYY", // Notice the Extra space at the beginning
        viewMode: "years",
        minDate: moment("<?php echo $this->config->item('minDate'); ?>"),
        maxDate : 'now'
    });
    
    $('.btn_subir_comprobante').click(function () {
        cargar_archivo($(this).attr('data-key'), "#form_material_educativo");
    });
</script>
<?php echo form_open('', array('id' => 'form_material_educativo')); ?>
<div class="list-group">
    <div class='row'>
        <div class="col-sm-3 col-md-3 col-lg-3"></div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <label for='lbl_tipo_material' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_tipo_material']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-user"> </span>
                </span>
                <?php
                echo $this->form_complete->create_element(array('id' => 'ctipo_material', 'type' => 'dropdown',
                    'options' => $ctipo_material,
                    'first' => array('' => $string_values['drop_tipo_material']),
                    'value' => (isset($material_educativo_cve)) ? $material_educativo_cve : '',
                    'attributes' => array('class' => 'form-control',
                        'placeholder' => $string_values['lbl_tipo_material'],
                        'data-toggle' => 'tooltip', 'data-placement' => 'top',
                        'title' => $string_values['lbl_tipo_material'],
                        'onchange' => "funcion_cargar_campos_tipo_material_educativo()"
                )));
                ?>
            </div>
            <?php echo form_error_format('ctipo_material'); ?>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3"></div>
    </div>
    <div class='row'>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <label for='lbl_nombre_material' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_nombre_material']; ?>
            </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-oil"> </span>
                </span>
                <?php
                echo $this->form_complete->create_element(array('id' => 'nombre_material',
                    'type' => 'text',
                    'value' => isset($nombre_material) ? $nombre_material : '',
                    'attributes' => array(
                        'class' => 'form-control',
                        'placeholder' => $string_values['texto_name_material'],
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'title' => $string_values['texto_name_material'])));
                ?>
            </div>
            <?php echo form_error_format('nombre_material'); ?>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <label for='lbl_tipo_material_anio_elaboro' class="control-label">
                <b class="rojo">*</b>
                <?php echo $string_values['lbl_tipo_material_anio_elaboro']; ?>
            </label>
            <div class="input-group">
                <div class="input-group date datepicker" id="datetimepicker1">
                    <?php
                    echo $this->form_complete->create_element(
                            array('id' => 'material_educativo_anio', 'type' => 'text',
                                'value' => isset($material_educativo_anio) ? $material_educativo_anio : '',
                                'attributes' => array(
                                    'class' => 'form-control',
                                    'placeholder' => $string_values['texto_tipo_material_anio_elaboro'],
                                    'min' => '1950',
                                    'max' => '2050',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'bottom',
                                    'title' => $string_values['texto_tipo_material_anio_elaboro'],
                                )
                            )
                    );
                    ?>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"> </span>
                    </span>
                </div>    
            </div>
            <?php echo form_error_format('material_educativo_anio'); ?>
        </div>
    </div>

    <?php
    if (isset($formulario_complemento)) {
        echo $formulario_complemento;
    }
    if (isset($formulario_carga_archivo)) {
        echo $formulario_carga_archivo;
    }
    ?>

</div>
<?php echo form_close(); ?>