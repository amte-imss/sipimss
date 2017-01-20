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

    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/evaluacion_curricular/evaluacion_curricular.js">
    </script>

    <!-- Inicio informacion personal -->

    <?php echo form_open('', array('id' => 'form_busqueda_evaluacion_curricular_validar')); ?>
    <div class="list-group">

    <div class="list-group-item">

        <div class="panel-body tab-content">
            <div id="select_buscador_validar_evaluacion" class="tab-pane fade active in">
                <div>
                    <br>
                    <h4><?php echo $string_values['titulo_template']; ?> </h4>
                    <br>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="panel-body input-group ">
                            <span class="input-group-addon"><?php echo $string_values['lbl_estado_validacion']; ?></span>
                            <?php
                            echo $this->form_complete->create_element(array('id' => 'cestado_validacion',
                                'type' => 'dropdown',
                                'options' => $cestado_validacion,
                                'first' => array('' => $string_values['drop_estado_validacion']),
                                'value' => '',
                                'class' => 'form-control',
                                'attributes' => array('class' => 'form-control', 'aria-describedby' => "help-tipo-comprobante",
                                    'placeholder' => $string_values['lbl_estado_validacion'],
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                    'title' => $string_values['lbl_estado_validacion'])));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="panel-body input-group">
                            <input type="hidden" id="menu_select" name="menu_busqueda" value="matricula">
                            <div class="input-group-btn">
                                <button id="btn_buscar_por" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $string_values['li_matricula']; ?><span class="caret"> </span></button>
                                <ul id="ul_menu_buscar_por" data-seleccionado='unidad' class="dropdown-menu borderlist">
                                    <li class="lip" onclick="funcion_menu_tipo_busqueda_validar_censo('matricula')"><?php echo $string_values['li_matricula']; ?></li>
                                    <li class="lip" onclick="funcion_menu_tipo_busqueda_validar_censo('nombre')"><?php echo $string_values['li_emp_nombre']; ?></li>
                                    <li class="lip" onclick="funcion_menu_tipo_busqueda_validar_censo('clavecategoria')"><?php echo $string_values['li_categoria']; ?></li>
                                </ul>

                            </div>

                            <?php
                            echo $this->form_complete->create_element(
                                    array('id' => 'buscador_docente', 'type' => 'text',
                                        'value' => '',
                                        'attributes' => array(
                                            'placeholder' => $string_values['txt_buscar_docentes'],
                                            'data-toggle' => 'tooltip',
                                            'data-placement' => 'bottom',
                                            'class' => 'form-control',
                                            'onkeypress' => 'return runScript_busqueda_val(event);',
                                            'title' => $string_values['txt_buscar_docentes'],
                                        )
                                    )
                            );
                            ?>
                            <div class="input-group-btn" >
                                <button type="button" id="btn_buscar_docentes_validacion" aria-expanded="false" 
                                        class="btn btn-default browse" 
                                        title="<?php echo$string_values['txt_buscar_docentes']; ?>" 
                                        data-toggle="tooltip" onclick="funcion_buscar_docentes_validar()" >
                                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if (isset($cdelegacion)) { ?>
                        <div class="col-md-6">
                            <div class="panel-body input-group ">
                                <span class="input-group-addon"><?php echo $string_values['lbl_delegacion']; ?></span>
                                <?php
                                echo $this->form_complete->create_element(array('id' => 'DELEGACION_CVE',
                                    'type' => 'dropdown',
                                    'options' => $cdelegacion,
                                    'first' => array('' => $string_values['drop_delegacion']),
                                    'value' => '',
                                    'class' => 'form-control',
                                    'attributes' => array('class' => 'form-control', 'aria-describedby' => "help-tipo-comprobante",
                                        'placeholder' => $string_values['lbl_delegacion'],
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'title' => $string_values['lbl_delegacion'])));
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (isset($cdepartamento)) { ?>
                        <div class="col-md-6">
                            <div class="panel-body input-group ">
                                <span class="input-group-addon"><?php echo $string_values['lbl_departamento']; ?></span>
                                <?php
                                echo $this->form_complete->create_element(array('id' => 'departamento_cve',
                                    'type' => 'dropdown',
                                    'options' => $cdepartamento,
                                    'first' => array('' => $string_values['drop_departamento']),
                                    'value' => '',
                                    'class' => 'form-control',
                                    'attributes' => array('class' => 'form-control', 'aria-describedby' => "help-tipo-comprobante",
                                        'placeholder' => $string_values['lbl_departamento'],
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'title' => $string_values['lbl_departamento'])));
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group">
                            <span class="input-group-addon">Número de registros a mostrar:</span>
                            <?php echo $this->form_complete->create_element(array('id' => 'per_page', 'type' => 'dropdown', 'options' => array(10 => 10, 20 => 20, 50 => 50, 100 => 100, 500 => 500), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Número de registros a mostrar', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Número de registros a mostrar', 'onchange' => "funcion_buscar_elementos()"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Ordenar por:</span>
                            <?php echo $this->form_complete->create_element(array('id' => 'order', 'type' => 'dropdown', 'options' => $order_columns, 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "funcion_buscar_elementos()"))); ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="panel-body input-group input-group-sm">
                            <span class="input-group-addon">Tipo de orden:</span>
                            <?php echo $this->form_complete->create_element(array('id' => 'order_type', 'type' => 'dropdown', 'options' => array('ASC' => 'Ascendente', 'DESC' => 'Descendente'), 'attributes' => array('class' => 'form-control', 'placeholder' => 'Ordernar por', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Ordenar por', 'onchange' => "funcion_buscar_elementos()"))); ?>
                        </div>
                    </div>
                </div>
                <?php if (isset($cdictamen)) { ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-body input-group ">
                                <span class="input-group-addon"><?php echo $string_values['lbl_enviar_evaluacion']; ?></span>
                                <?php
                                echo $this->form_complete->create_element(array('id' => 'cdictamen',
                                    'type' => 'dropdown',
                                    'options' => $cdictamen,
                                    'first' => array('' => $string_values['drop_dictamen']),
                                    'value' => '',
                                    'attributes' => array('class' => 'form-control', 'aria-describedby' => "help-tipo-comprobante",
                                        'placeholder' => $string_values['lbl_dictamen'],
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'title' => $string_values['lbl_dictamen'])));
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel-body input-group ">
                                <?php
                                echo $this->form_complete->create_element(array('id' => 'cdictamen',
                                    'type' => 'button',
                                    'options' => $cdictamen,
                                    'value' => $string_values['lbl_enviar_evaluacion'],
                                    'class' => 'form-control',
                                    'attributes' => array(
                                        'placeholder' => $string_values['lbl_enviar_evaluacion'],
                                        'class' => 'btn btn-success btn-md',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'title' => $string_values['lbl_enviar_evaluacion'])));
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php echo form_close(); ?>
                <div class="row" >
                    <div id="div_result_docentes_validacion_evaluacion" class="row" style="padding:0 20px;">

                    </div>
                </div>
            </div>
            <div id="select_perfil_validar_evaluacion" class="tab-pane fade">

            </div>
        </div>    

    </div>
</div>






