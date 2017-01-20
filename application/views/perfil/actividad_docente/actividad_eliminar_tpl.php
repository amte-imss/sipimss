<?php defined('BASEPATH') OR exit('No direct script access allowed');
        $fecha_ultima_actualizacion = 'Fecha de última actualizacón: 11 de julio de 2016 ';
?>

    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/perfil/actividad_docente.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/perfil/informacionGeneral.js"></script>
    
    <!-- Inicio informacion personal -->
    <?php echo form_open('', array('id'=>'form_elimiar_actividad_docente')); ?>
    
    <div class="list-group">
        
        <?php if(isset($error)){ ?>
        <div class="list-group-item">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                           <?php echo html_message($error, $tipo_msg); ?>
                    </div>
                    <div class="col-md-1 col-sm-1 col-xs-1"></div>
                </div>
        
        <?php } ?>
         <?php if(isset($pregunta) AND !isset($borrado_correcto)){ ?>
        <div class="list-group-item">
            <div class='row'>
                <div class="col-md-12 col-sm-12 col-xs-12 text-center" >
                    <label for='lbl_area' class="control-label">
                         <?php echo $pregunta; ?>
                    </label>
                </div>
            </div>
         <br>
            <div class='row'>
                <div class="col-md-6 col-sm-6 col-xs-6 text-right" >
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button id="btn_guardar_actividad_especifica" type="button" class="btn btn-secondary" onclick="funcion_eliminar_actividad_docente(<?php echo $index_tp_actividad; ?>,<?php echo $index_entidad; ?>,<?php echo $is_cur_principal ?>, 1)">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
         <?php }else if (!isset($borrado_correcto)){ ?>
                <div class='row'>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-right" >
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
         <?php }else{ ?>
                <script type="text/javascript">
                      cargar_datos_menu_perfil('get_data_ajax_actividad');//Actualiza datos, nombre del botón actividad docente del menu principal perfil 
                </script>
                <div class='row'>
                    <div class="col-md-6 col-sm-6 col-xs-6 text-right" >
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
         <?php } ?>
    
    </div>
    
    
    <?php echo form_close(); ?>
  