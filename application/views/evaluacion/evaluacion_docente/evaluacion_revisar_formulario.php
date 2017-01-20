<?php echo js('evaluacion/evaluacion_docente_revisar.js'); ?>
<div id="capa_html">
	<?php echo form_open('', array('id' => 'form_busqueda_docentes_evaluar')); ?>
    <div class="list-group">
	    <div class="list-group-item">
	        <div class="panel-body tab-content">
	            <div id="select_buscador_validar" class="tab-pane fade active in">
	                <div class="row">
	                    <div class="col-md-6 col-lg-6 col-sm-6">
	                        <div class="panel-body input-group">
	                            <input type="hidden" id="menu_select" name="menu_busqueda" value="matricula">
	                            <div class="input-group-btn">
	                                <button id="btn_buscar_por" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default dropdown-toggle " data-toggle="tooltip" data-original-title="Buscar por"><?php echo $string_values['matricula_docente']; ?><span class="caret"> </span></button>
	                                <ul id="ul_menu_buscar_por" data-seleccionado='unidad' class="dropdown-menu borderlist">
	                                    <li class="lip" onclick="funcion_menu_tipo_busqueda_evaluar_censo('matricula')"><?php echo $string_values['matricula_docente']; ?></li>
	                                    <li class="lip" onclick="funcion_menu_tipo_busqueda_evaluar_censo('nombre')"><?php echo $string_values['nombre_docente']; ?></li>
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
	                                <button type="button" id="btn_buscar_docentes_evaluacion_revisar" aria-expanded="false" 
	                                        class="btn btn-default browse" 
	                                        title="<?php echo $string_values['txt_buscar_docentes']; ?>" 
	                                        data-toggle="tooltip">
	                                    <span aria-hidden="true" class="glyphicon glyphicon-search"></span>
	                                </button>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-md-6 col-lg-6 col-sm-6" style="padding-top: 15px;"><?php echo $string_values['periodo_actual_evaluacion'].': '; echo (isset($dictamen[0]['FCH_INICIO_EVALUACION']) && isset($dictamen[0]['FCH_FIN_EVALUACION'])) ? nice_date($dictamen[0]['FCH_INICIO_EVALUACION'], 'd-m-Y').' - '.nice_date($dictamen[0]['FCH_FIN_EVALUACION'], 'd-m-Y') : ''; ?></div>
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
	                <?php echo form_close(); ?>
	                <div class="row" >
	                    <div id="div_result_docentes_evaluacion" class="row" style="padding:0 20px;">

	                    </div>
	                </div>
	            </div>
	            <div id="select_perfil_validar_evaluacion" class="tab-pane fade"></div>
	        </div>
	    </div>
	</div>
</div>