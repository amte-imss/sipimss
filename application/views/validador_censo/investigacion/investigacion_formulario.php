<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($select_inv) AND ! empty($select_inv)) {
//    pr($select_inv);
    //Convertimos los index del array en variables
    extract($select_inv, EXTR_OVERWRITE); //EXTR_IF_EXISTS; EXTR_PREFIX_ALL; EXTR_OVERWRITE; EXTR_PREFIX_INVALID
    if (!empty($cita_publicada)) {
        switch ($divulgacion) {
            case '3':
                $bibliografia_revista = $cita_publicada;
                break;
            case '4':
                $bibliografia_libro = $cita_publicada;
                break;
        }
    }

//            $algo = implode($glue, $pieces)
}

$div_stile_display_comprobante = ' none';
$div_stile_display_libro = ' none';
$div_stile_display_revista = ' none';
if (!empty($divulgacion)) {
    switch ($divulgacion) {
        case '3':
            $div_stile_display_revista = ' block';
            break;
        case '4':
            $div_stile_display_libro = ' block';
            break;
        default :
            $div_stile_display_comprobante = ' block';
    }
}
?>
<script>
    var nextinput = 0;
    var nextinput = 0;
    control_generados = new Object();//Control de elementos agregados
    var htipos_bibliografia = new Object();
    //0-> Cantidad, de objetos permitidos, numericamente, es decir 0 = 0; 1 = 1; 11 = 11; y -1 = n-cantidad indefinida; |
    //1-> Nombre de las propiedades, las contiene el boton agregar, es importante "sin espacios ni caractres especiales" |
    //2-> Id del "div" que mostrará los cambios |
    //3-> Id del  boton agregar  |
    //4-> Nombre de los input separados por $ y al final |
    //5-> placeholder de los input, debe ser de igual tamaño de argumentos que el punto 4, separado por $ y al final |
    //6-> Titulo del parrafo o del "li" y al final |
    htipos_bibliografia["autor"] = "-1|autor|div_autores_1|btn_add_autor|autornom_$autorap_$|Nombre(s)$Apellido paterno$|Agregar autor";
    htipos_bibliografia["titulolibro"] = "1|titulolibro|div_tit_lib|btn_add_tit_libro|titulolibro_$|Titulo del libro$|Titulo de libro";
    htipos_bibliografia["edicion"] = "1|edicion|div_edicion_lib|btn_add_edicion_lib|edicionlib_$|Agregar edición$|Edición";
    htipos_bibliografia["editor"] = "1|editor|div_editor_lib|btn_add_editor_lib|editorlib_$|Agregar editor$|Editor";
    htipos_bibliografia["lugaredicion"] = "1|lugaredicion|div_lugar_edicion_lib|btn_add_lugar_edicion_lib|lugaredicionlib_$|Agregar lugar de edició$|Lugar de edición";
    htipos_bibliografia["editorial"] = "1|editorial|div_editorial_lib|btn_add_editorial_lib|editoriallib_$|Agregar editorial$|Editorial";
    htipos_bibliografia["anio"] = "3|anio|div_anio_lib|btn_add_anio_lib|aniolib_$|Agregar año de edición$|Agregar año|";
</script>

<div class="list-group">
    <div class="list-group-item">
        <div class="panel-body">
            <div class='row'>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label for='lbl_tipo_actividad_docente' class="control-label">
                        <?php echo $string_values['lbl_tipo_actividad_docente']; ?>
                    </label>
                    <div class="input-group">
                        <label class="registro"><?php echo $dir_tes['tpad_nombre']; ?></label>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class='row'>
                <div class="col-md-6">
                    <label for='lbl_name_trabajo_investigacion' class="control-label">
                        <?php echo $string_values['lbl_name_trabajo_investigacion']; ?>
                    </label>
                    <div class="input-group">
                        <label class="registro"><?php echo $dir_tes['nombre_investigacion']; ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for='txt_num_folio' class="control-label">
                        <?php echo $string_values['txt_num_folio']; ?>
                    </label>
                    <div class="input-group">
                        <label class="registro"><?php echo $dir_tes['folio_investigacion']; ?></label>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class="col-md-6">
                    <label for='lbl_tipo_estudio' class="control-label">
                        <?php echo $string_values['lbl_tipo_estudio']; ?>
                    </label>
                    <div class="input-group">
                        <label class="registro"><?php echo $dir_tes['TIP_EST_NOMBRE']; ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for='lbl_tipo_participacion' class="control-label">
                        <?php echo $string_values['lbl_tipo_participacion']; ?>
                    </label>
                    <div class="input-group">
                        <label class="registro"><?php echo $dir_tes['TIP_PAR_NOMBRE']; ?></label>
                    </div>
                </div>
            </div>
            <br>
            <div class='row'>
                <div class='col-md-6 col-sm-6 col-lg-6' >
                    <label for='lbl_tipo_divulgacion' class="control-label">
                        <?php echo $string_values['lbl_tipo_divulgacion']; ?>
                    </label>
                    <div class="input-group">
                        <label class="registro"><?php echo $dir_tes['MED_DIV_NOMBRE']; ?></label>
                    </div>
                </div>
            </div>
            <div class='row' id="div_mostrar_comprobante_libro_revista">
                <?php
                //Miuestrá el cargador de archivos, la bibliografía del libro o revista
                if (isset($formulario_carga_opt_tipo_divulgacion)) {
                    echo $formulario_carga_opt_tipo_divulgacion;
                }
                ?>
            </div>
            <?php echo $formulario_validacion; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
    $('#modal_censo').on('hide.bs.modal', function (e) {
        cargar_datos_menu_perfil('seccion_investigacion');
        recargar_fecha_ultima_actualizacion();
    });
});
</script>