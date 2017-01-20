<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
$fecha_ultima_actualizacion = 'Fecha de última actualizacón: 11 de julio de 2016 ';
?>

<style type="text/css">
    .button-padding {padding-top: 30px}
    .rojo {color: #a94442}.panel-body table{color: #000} .pinfo{padding-left:20px; padding-bottom: 20px;}
    /*Oculta el file para cargar comprobante y deja asi solo muestra un botón*/
    .borderlist {    list-style-position:inside; border: 1px solid #8c9494}
    .lip { cursor: pointer;
           display:block; }
</style>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/designar_validador/designar_validador.js">
</script>

<!-- Inicio informacion personal -->

<?php echo form_open('', array('id' => 'form_busqueda_unidades')); ?>
<div class="list-group">

<!--    <div class="list-group-item">
        <div class="row" >
            <div class="col-md-12 col-sm-12 col-xs-12 " id='div_error_index' style='display:none'>
                <div id='mensaje_error_div_index' class='alert'>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span id='mensaje_error_index'></span>
                </div>
            </div>
        </div>
    </div>-->
        
        <div class="panel-body imss-background-white imss-border-gray">
            <div class="imss-center-content imss-border-bottom">
                <h2><?php echo $string_values['titulo_template']; ?> </h2>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel-body input-group">
                            <input type="hidden" id="menu_select" name="menu_busqueda" value="unidad">
                            <div class="input-group-btn">
                              <button id="btn_buscar_por" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por">Unidad <span class="caret"> </span></button>
                              <ul id="ul_menu_buscar_por" data-seleccionado='unidad' class="dropdown-menu borderlist">
                                  <li class="lip" onclick="funcion_menu_tipo_busqueda('unidad')"><?php echo $string_values['li_unidad'];?></li>
                                  <li class="lip" onclick="funcion_menu_tipo_busqueda('claveadscripcion')"><?php echo $string_values['li_clave_adscripcion'];?></li>
                                  <li class="lip" onclick="funcion_menu_tipo_busqueda('matricula')"><?php echo $string_values['li_matricula'];?></li>
                                  <li class="lip" onclick="funcion_menu_tipo_busqueda('nombre')"><?php echo $string_values['li_emp_nombre'];?></li>
                              </ul>

                            </div>
                          
                         <?php
                            echo $this->form_complete->create_element(
                            array('id'=>'buscar_unidad_medica','type'=>'text',
                                    'value' => '',
                                    'attributes'=>array(
                                    'placeholder'=>$string_values['txt_buscar_unidad'],
                                    'data-toggle'=>'tooltip',
                                    'data-placement'=>'bottom',
                                    'class' => 'form-control',
                                    'onkeypress'=>'return runScript(event);',//control key del enter para buscar
                                    'title'=>$string_values['txt_buscar_unidad'],
//                                        'readonly'=>'readonly',
                                    )
                                )
                            );
                         ?>
                        <div class="input-group-btn" >
                            <button type="button" id="btn_buscar_b" aria-expanded="false" class="btn btn-default browse" title="<?php echo$string_values['txt_buscar_unidad'];?>" data-toggle="tooltip" onclick="funcion_buscar_elementos()" ><span aria-hidden="true" class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group">
                            <span class="input-group-addon">Número de registros a mostrar:</span>
                            <?php echo $this->form_complete->create_element(array('id'=>'per_page', 'type'=>'dropdown', 'options'=>array(10=>10, 20=>20, 50=>50, 100=>100, 500=>500), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Número de registros a mostrar', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Número de registros a mostrar', 'onchange'=>"funcion_buscar_elementos()"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Ordenar por:</span>
                            <?php echo $this->form_complete->create_element(array('id'=>'order', 'type'=>'dropdown', 'options'=>$order_columns, 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"funcion_buscar_elementos()"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Tipo de orden:</span>
                            <?php echo $this->form_complete->create_element(array('id'=>'order_type', 'type'=>'dropdown', 'options'=>array('ASC'=>'Ascendente', 'DESC'=>'Descendente'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>'Ordernar por', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Ordenar por', 'onchange'=>"funcion_buscar_elementos()"))); ?>
                        </div>
                    </div>
            </div>
            <div class="row" >
                <div id="div_result_unidades_medicas" class="row" style="padding:0 20px;">

                </div>
            </div>
        </div>
        <?php echo form_close(); ?>

</div>






  