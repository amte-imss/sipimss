<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="col-md-6">
    <!--
    <label for='lbl_bb_revista' class="control-label">
        <b class="rojo">*</b>
        <?php/* echo $string_values['lbl_bb_revista']; ?>
    </label>
    <div class="input-group">
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-education"> </span>
        </span>
        <?php/*
        echo //$this->form_complete->create_element(array('id' => 'bibliografia_revista',
            'type' => 'textarea',
            'value' => (isset($bibliografia_revista)) ? $bibliografia_revista : '',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => $string_values['txt_bb_revista'],
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'title' => $string_values['txt_bb_revista'])));
        */?>
    </div>
    <?php //echo form_error_format('bibliografia_revista'); */?>
    -->
    <div class="well">        
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label for="ISBN_LIB ">ISSN:</label>
            <?php 
            echo $this->form_complete->create_element(array('id' => 'ISBN_LIB', 'type' => 'text', 'attributes' => array('name' => 'ISBN_LIB', 'class' => 'form-control', 'placeholder' => 'Escribe el ISSN de la revista (*Campo opcional)', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'ISSN de la revista'))); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
            ?>
            <span class="text-danger"> <?php echo form_error('ISBN_LIB','','');?> </span>
            <p class="help-block"></p>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label>
                <?php 
                echo $this->form_complete->create_element(array('id' => 'is_edic_comp', 'name'=>'is_edic_comp', 'type' => 'checkbox', 'value'=>'1')); //,'onchange' => "data_ajax(site_url+'/encuestas/get_respuesta_esperada_ajax/".$val_ref."', '#edita_pregunta', '#respuesta_esperada')"        --  'options' => $preguntas_padre,'value'=>$pregunta_padre
                ?>
                Es editorial
            </label><br>
            <span class="text-danger"> <?php echo form_error('is_edic_comp','','');?> </span>
            <p class="help-block"></p>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-6">
</div>