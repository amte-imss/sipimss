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