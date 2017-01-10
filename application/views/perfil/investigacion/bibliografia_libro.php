<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="col-md-6">
    <!--<label for='lbl_bb_libro' class="control-label">
        <b class="rojo">*</b>
        <?php //echo $string_values['lbl_bb_libro']; ?>
    </label>
    <div class="input-group">
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-education"> </span>
        </span>
        <?php
        //echo $this->form_complete->create_element(array('id' => 'bibliografia_libro',
            //'type' => 'textarea',
            //'value' => (isset($bibliografia_libro)) ? $bibliografia_libro : '',
            //'attributes' => array(
            //   'class' => 'form-control',
            //    'placeholder' => $string_values['txt_bb_libro'],
            //    'data-toggle' => 'tooltip',
            //    'data-placement' => 'top',
            //    'title' => $string_values['txt_bb_libro'])));
        ?>
    </div>
    <?php //echo form_error_format('bibliografia_libro'); ?>
    -->
    <div class="well">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label for="ISBN_LIB ">ISBN:</label>
            <?php 
            echo $this->form_complete->create_element(array('id' => 'ISBN_LIB', 'type' => 'text', 'attributes' => array('name' => 'ISBN_LIB', 'class' => 'form-control', 'placeholder' => 'Escribe el ISBN del libro (*Campo opcional)', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'ISBN del libro'))); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
            ?>
            <span class="text-danger"> <?php echo form_error('ISBN_LIB','','');?> </span>
            <p class="help-block"></p>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label for="num_paginas ">Número de páginas:</label>
            <?php 
            echo $this->form_complete->create_element(array('id' => 'num_paginas', 'type' => 'number', 'attributes' => array('name' => 'num_paginas', 'class' => 'form-control','max'=>'999999','min'=>'0', 'placeholder' => 'Número de páginas', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de páginas'))); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
            ?>
            <span class="text-danger"> <?php echo form_error('num_paginas','','');?> </span>
            <p class="help-block"></p>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label for="num_capitulos">Número de capitulos:</label>
            <?php 
            echo $this->form_complete->create_element(array('id' => 'num_capitulos', 'type' => 'number', 'attributes' => array('name' => 'num_capitulos', 'class' => 'form-control','max'=>'5', 'min'=>'0', 'placeholder' => 'Número de capitulos', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de capitulos'))); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
            ?>
            <span class="text-danger"> <?php echo form_error('num_capitulos','','');?> </span>
            <p class="help-block"></p>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label>
                <?php 
                echo $this->form_complete->create_element(array('id' => 'is_edic_comp', 'name'=>'is_edic_comp', 'type' => 'radio', 'value'=>'1')); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
                ?>
                Edición
            </label>
            <label>
                <?php 
                echo $this->form_complete->create_element(array('id' => 'is_edic_comp', 'name'=>'is_edic_comp', 'type' => 'radio', 'value'=>'2')); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre


                ?>
                Compilación
            </label>
            <span class="text-danger"> <?php echo form_error('is_edic_comp','','');?> </span>
            <p class="help-block"></p>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-6"></div>