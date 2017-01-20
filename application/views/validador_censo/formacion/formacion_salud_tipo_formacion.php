<?php
if(count($catalogos['csubtipo_formacion_salud'])>0){
	?>
	<div class='col-sm-12 col-md-12 col-lg-4 text-right'>
	    <label class="control-label">
	        * <?php echo $string_values['lbl_subtipo_formacion']; ?>:
	    </label>
	</div>
	<div class='col-sm-12 col-md-12 col-lg-8 text-left'>
		<div class="form-group">
		    <div class="input-group">
		        <?php
		        echo $this->form_complete->create_element(array('id'=>'subtipo', 'type'=>'dropdown', 'value'=>$dir_tes['CSUBTIP_FORM_SALUD_CVE'], 'options'=>$catalogos['csubtipo_formacion_salud'], 'first'=>array(''=>'Selecciona...'), 'attributes'=>array('class'=>'form-control', 'placeholder'=>$string_values['lbl_subtipo_formacion'], 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>$string_values['lbl_subtipo_formacion'])));
		        ?>
		    </div>
		</div>
		<?php //echo form_error_format('curso'); ?>	
	</div>
	<?php
}
?>

