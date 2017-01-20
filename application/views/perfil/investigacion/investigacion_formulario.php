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

<?php echo form_open_multipart('', array('id' => 'form_investigacion_docente')); ?>
<div class="list-group">
    <div class="list-group-item">
        <div class="panel-body">
            <div class='row'>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <label for='lbl_tipo_actividad_docente' class="control-label">
                        <?php echo $string_values['lbl_tipo_investigacion_docente']; ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-user"> </span>
                        </span>
                        <?php
                        echo $this->form_complete->create_element(array('id' => 'ctipo_actividad_docente', 'type' => 'dropdown',
                            'options' => $ctipo_actividad_docente,
                            'first' => array('' => 'Selecciona tipo de actividad'),
                            'value' => (isset($tpad_cve)) ? $tpad_cve : '',
                            'attributes' => array('name' => 'categoria', 'class' => 'form-control',
                                'placeholder' => 'Categoría', 'data-toggle' => 'tooltip', 'data-placement' => 'top',
                            )
                        ));
                        ?>
                    </div>
                    <?php echo form_error_format('ctipo_actividad_docente'); ?>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class='row'>
                <!--<div class="form-group col-xs-10 col-md-10 col-md-offset-1 col-md-offset-1">-->
                <div class="col-md-6">
                    <label for='lbl_name_trabajo_investigacion' class="control-label">
                        <b class="rojo">*</b>
                        <?php echo $string_values['lbl_name_trabajo_investigacion']; ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-education"> </span>
                        </span>
                        <?php
                        echo $this->form_complete->create_element(array('id' => 'nombre_investigacion',
                            'type' => 'text',
                            'value' => (isset($nombre_investigacion)) ? $nombre_investigacion : '',
                            'attributes' => array(
                                'class' => 'form-control',
                                'placeholder' => $string_values['text_name_trabajo_investigacion'],
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'title' => $string_values['text_name_trabajo_investigacion'])));
                        ?>
                    </div>
                    <?php echo form_error_format('nombre_investigacion'); ?>
                </div>
                <div class="col-md-6">
                    <label for='txt_num_folio' class="control-label">
                        <b class="rojo">*</b>
                        <?php echo $string_values['txt_num_folio']; ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-education"> </span>
                        </span>
                        <?php
                        echo $this->form_complete->create_element(array('id' => 'folio_investigacion',
                            'type' => 'text',
                            'value' => (isset($folio_investigacion)) ? $folio_investigacion : '',
                            'attributes' => array(
                                'class' => 'form-control',
                                'placeholder' => $string_values['txt_num_folio'],
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'title' => $string_values['txt_num_folio'])));
                        ?>
                    </div>
                    <?php echo form_error_format('folio_investigacion'); ?>
                </div>
            </div>
            <div class='row'>
                <!--<div class="col-md-6">
                    <label for='lbl_tipo_estudio' class="control-label">
                        <b class="rojo">*</b>
                        <?php //echo $string_values['lbl_tipo_estudio']; ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-oil"> </span>
                        </span>
                        <?php /*
                        echo $this->form_complete->create_element(array('id' => 'ctipo_estudio', 'type' => 'dropdown',
                            'options' => $ctipo_estudio,
                            'first' => array('' => $string_values['drop_tipo_estudio']),
                            'value' => (isset($tip_estudio_cve)) ? $tip_estudio_cve : '',
                            'attributes' => array('name' => 'categoria', 'class' => 'form-control',
                                'placeholder' => 'Categoría', 'data-toggle' => 'tooltip', 'data-placement' => 'top',
                                'title' => $string_values['lbl_tipo_estudio'])));
                        */?>
                    </div>
                    <?php //echo form_error_format('ctipo_estudio'); ?>
                </div>-->
                <div class="col-md-6 pull-right">
                    <label for='lbl_tipo_participacion' class="control-label">
                        <b class="rojo">*</b>
                        <?php echo $string_values['lbl_tipo_participacion']; ?>
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-oil"> </span>
                        </span>
                        <?php
                        echo $this->form_complete->create_element(array('id' => 'ctipo_participacion', 'type' => 'dropdown',
                            'options' => $ctipo_participacion,
                            'first' => array('' => $string_values['drop_tipo_participacion']),
                            'value' => (isset($tip_participacion_cve)) ? $tip_participacion_cve : '',
                            'attributes' => array('name' => 'categoria', 'class' => 'form-control',
                                'placeholder' => 'Categoría', 'data-toggle' => 'tooltip', 'data-placement' => 'top',
                                'title' => $string_values['lbl_tipo_participacion'])));
                        ?>
                    </div>
                    <?php echo form_error_format('ctipo_participacion'); ?>
                </div>
             <!--</div>
            <br>
            <div class='row'>-->
                <div class='col-md-6 col-sm-6 col-lg-6' >
                    <label for='lbl_tipo_divulgacion' class="control-label">
                        <b class="rojo">*</b>
                        <?php echo $string_values['lbl_tipo_divulgacion']; ?>
                    </label>
                    <div class="btn-group pull-right" data-toggle="buttons">
                            <span class="btn btn-info btn-sm" onclick="funcion_mostrar_medio_divulgacion(1);"><input type="radio" name="articulo" id="articulo1" value="1" autocomplete="off">Foro/Congreso</span>
                            <span class="btn btn-info btn-sm" onclick="funcion_mostrar_medio_divulgacion(2);"><input type="radio" name="articulo" id="articulo1" value="2" autocomplete="off">Libro</span> <!-- data-toggle="collapse" data-target="#div_numero_paginas" aria-expanded="false" aria-controls="collapseExample" -->
                            <span class="btn btn-info btn-sm" onclick="funcion_mostrar_medio_divulgacion(3);"><input type="radio" name="articulo" id="articulo1" value="3" autocomplete="off">Revista</span>
                    </div>
                    <br>
                    <div id="medio_divulgacion_div">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-oil"> </span>
                        </span>
                        <?php
                        echo $this->form_complete->create_element(array('id' => 'cmedio_divulgacion', 'type' => 'dropdown',
                            'options' => $cmedio_divulgacion,
                            'first' => array('' => $string_values['drop_tipo_divulgacion']),
                            'value' => (isset($med_divulgacion_cve)) ? $med_divulgacion_cve : '',
                            'attributes' => array('name' => 'categoria', 'class' => 'form-control',
                                'placeholder' => 'Categoría', 'data-toggle' => 'tooltip', 'data-placement' => 'top',
                                'title' => $string_values['lbl_tipo_divulgacion'],
                                'onchange' => "funcion_mostrar_tipo_publicacion(this)"
                        )));
                        ?>
                    </div>
                    </div>
                    <!-- -->
                    <!--
                    <label data-toggle="collapse" data-target="#div_pregunta_padre" aria-expanded="false" aria-controls="collapseExample">
                        <?php 
                        //echo $this->form_complete->create_element(array('id' => 'tiene_pregunta_padre', 'type' => 'checkbox', 'value'=>1, 'attributes' => array('name' => 'tiene_pregunta_padre', 'checked'=>$check_padre))); 
                        ?>
                        Tiene pregunta padre
                    </label><br>
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#div_pregunta_padre" aria-expanded="false" aria-controls="collapseExample">
                        Seleccione aquí si el medio de divulgación fue libro
                    </button>-->
                    <!--<div class="collapse" id="div_numero_paginas">
                        <div class="well">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="num_paginas ">Número de páginas:</label>
                                <?php 
                                //echo $this->form_complete->create_element(array('id' => 'num_paginas', 'type' => 'number', 'attributes' => array('name' => 'numero_paginas', 'class' => 'form-control','maxlength'=>'5', 'placeholder' => 'Número de páginas', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de páginas'))); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
                                ?>
                                <span class="text-danger"> <?php //echo form_error('num_paginas','','');?> </span>
                                <p class="help-block"></p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="num_capitulos">Número de capitulos:</label>
                                <?php 
                                //echo $this->form_complete->create_element(array('id' => 'num_capitulos', 'type' => 'number', 'attributes' => array('name' => 'numero_paginas', 'class' => 'form-control','max'=>'5', 'min'=>'0', 'placeholder' => 'Número de capitulos', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de capitulos'))); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
                                ?>
                                <span class="text-danger"> <?php //echo form_error('num_capitulos','','');?> </span>
                                <p class="help-block"></p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label>
                                    <?php 
                                     //echo $this->form_complete->create_element(array('id' => 'is_edic_comp', 'name'=>'is_edic_comp', 'type' => 'radio', 'value'=>'1')); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
                                    ?>
                                    Edición
                                </label>
                                <label>
                                    <?php 
                                     //echo $this->form_complete->create_element(array('id' => 'is_edic_comp', 'name'=>'is_edic_comp', 'type' => 'radio', 'value'=>'2')); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
                                    ?>
                                    Compilación
                                </label>
                                <span class="text-danger"> <?php //echo form_error('is_edic_comp','','');?> </span>
                                <p class="help-block"></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>-->
                    <!-- -->
                    <?php echo form_error_format('cmedio_divulgacion'); ?>
                </div>
                <!--<div class='col-md-6 col-sm-6 col-lg-6' >
                    <span id="help-tipo-comprobante" class="help-block"><?php //echo $string_values['Texto_de_ayuda_divulgacion']; ?></span>
                </div>-->
            </div>
            <div class='row' id="div_mostrar_comprobante_libro_revista">
                <?php
                //Miuestrá el cargador de archivos, la bibliografía del libro o revista
                if (isset($formulario_carga_opt_tipo_divulgacion)) {
                    echo $formulario_carga_opt_tipo_divulgacion;
                }
                ?>           
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
