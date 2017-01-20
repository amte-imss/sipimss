<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <style type="text/css">
        /*.button-padding {padding-top: 30px}*/
        /*.rojo {color: #a94442}.panel-body table{color: #000} .pinfo{padding-left:20px; padding-bottom: 20px;}*/
        /*.userfile {visibility: hidden;  position: absolute;}Oculta el file para cargar comprobante y deja asi solo muestra un botón*/
    </style>

    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/perfil/actividad_docente.js"></script>
    
    <!-- Inicio informacion personal -->
    
    <div class="list-group">
            <?php if(isset($ctipo_actividad_docente)){ ?>
           <div class="list-group-item">
                <?php // echo form_open('', array('id'=>'form_actividad_docente_general')); ?>
                <label for='lbl_tipo_actividad_docente_' class="control-label">
                     <?php echo $string_values['lbl_tipo_actividad_docente']; ?>
                </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-user"> </span>
                    </span>
                    <?php 
                        echo $this->form_complete->create_element(array('id' => 'ctipo_actividad_docente', 'type' => 'dropdown', 
                            'options' => $ctipo_actividad_docente, 
                            'first' => (isset($nada))? $nada : array('' => 'Selecciona tipo de actividad'), 
                            'value' => '',
                            'attributes' => array('class' => 'form-control', 
                            'placeholder' => 'Categoría', 
                            'data-toggle' => 'tooltip', 
                            'data-placement' => 'top', 
                            'onchange' =>  "function_carga_form_actividad_doc()"   
                            )
                       )); 
                    ?>
               </div>
               <?php   echo form_error_format('ctipo_actividad_docente'); ?>
           </div>
            <?php // echo form_close(); ?>
            <?php  }?>
                <?php //echo form_open('', array('id'=>'form_actividad_docente_especifico')); ?>
            <div class="list-group-item" id="info_actividad_docente">
               <!--Carga la vista correspondiente al elemento tipo de actividad del docente-->
               <?php   if(isset($formulario)){ echo $formulario; } ?>
           </div>
               <?php //echo form_close(); ?>
        </div>
    
    
  